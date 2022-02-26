<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Ambil data pemesanan per meja
        $paymentLists = Order::where([
            ['is_ready_to_be_paid', 1],
            ['order_code', '!=', null],
            ['is_paid', 0],
            ['is_done', 0],
            ['payment_type', 'cash'],
            ['is_delivered', 1]
        ])->get()->groupBy('order_code');

        // dd(array_sum(array_column($paymentLists->first()->toArray(), 'total_price')));

        return view('kasir.pembayaran.index', compact('paymentLists'));
    }

    public function historyIndex()
    {
        // Ambil data pemesanan per meja
        $paymentLists = Order::where([
            ['is_ready_to_be_paid', 1],
            ['is_paid', 1],
            ['is_done', 1],
            ['is_delivered', 1]
        ])->get()->groupBy('order_code');

        // dd(array_sum(array_column($paymentLists->first()->toArray(), 'total_price')));

        return view('kasir.history.index', compact('paymentLists'));
    }

    public function cash($id)
    {
        // dd($id);
        // Update order menjadi selesai dan dibayar

        Order::where('order_code', $id)->update([
            'is_done' => 1
        ]);

        Order::where([
            ['order_code', $id],
            ['is_delivered', 1]
        ])->update([
            'is_paid' => 1
        ]);

        return redirect('/pembayaran');
    }
    public function searchHistory()
    {
        // Ambil data pemesanan per meja
        $paymentLists = Order::where([
            ['is_ready_to_be_paid', 1],
            ['is_paid', 1],
            ['is_done', 1],
            ['is_delivered', 1]
        ])->where(function ($query) {
            // Ambil query
            $search = request()->all()['query'];
            $query->where('table_number', 'like', '%' . $search . '%')
                ->orWhere('customer_name', 'like', '%' . $search . '%')
                ->orWhere('order_code', 'like', '%' . $search . '%');
        })->get()->groupBy('order_code');

        return view('kasir.history.index', compact('paymentLists'));
    }

    public function searchPayment()
    {
        if (request('query') == null) {
            return redirect('/pembayaran');
        }
        // Ambil data pemesanan per meja
        $paymentLists = Order::where([
            ['is_ready_to_be_paid', 1],
            ['order_code', '!=', null],
            ['is_paid', 0],
            ['is_done', 0],
            ['is_delivered', 1]
        ])->where(function ($query) {
            // Ambil query
            $search = request()->all()['query'];
            $query->where('table_number', 'like', '%' . $search . '%')
                ->orWhere('customer_name', 'like', '%' . $search . '%')
                ->orWhere('order_code', 'like', '%' . $search . '%');
        })->get()->groupBy('order_code');

        $is_search = true;

        return view('kasir.pembayaran.index', compact('paymentLists', 'is_search'));
    }

    public function notification(Request $request)
    {
        $payload = $request->getContent();
        $notification = json_decode($payload);

        $validSignatureKey = hash("sha512", $notification->order_id . $notification->status_code . $notification->gross_amount . env('MIDTRANS_SERVER_KEY'));

        if ($notification->signature_key != $validSignatureKey) {
            return response(['message' => 'Invalid signature'], 403);
        }

        $this->initPaymentGateway();
        $statusCode = null;

        $paymentNotification = new \Midtrans\Notification();
        $order = Order::where('order_code', $paymentNotification->order_id)->get()[0];

        // dd($order->is_done);

        if ($order->is_done == true) {
            return response(['message' => 'The order has been paid before'], 422);
        }

        $transaction = $paymentNotification->transaction_status;
        $type = $paymentNotification->payment_type;
        $orderId = $paymentNotification->order_id;
        $fraud = $paymentNotification->fraud_status;

        $vaNumber = null;
        $vendorName = null;
        if (!empty($paymentNotification->va_numbers[0])) {
            $vaNumber = $paymentNotification->va_numbers[0]->va_number;
            $vendorName = $paymentNotification->va_numbers[0]->bank;
        }

        $paymentStatus = null;
        if ($transaction == 'capture') {
            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    // TODO set payment status in merchant's database to 'Challenge by FDS'
                    // TODO merchant should decide whether this transaction is authorized or not in MAP
                    $paymentStatus = Payment::CHALLENGE;
                } else {
                    // TODO set payment status in merchant's database to 'Success'
                    $paymentStatus = Payment::SUCCESS;
                }
            }
        } else if ($transaction == 'settlement') {
            // TODO set payment status in merchant's database to 'Settlement'
            $paymentStatus = Payment::SETTLEMENT;
        } else if ($transaction == 'pending') {
            // TODO set payment status in merchant's database to 'Pending'
            $paymentStatus = Payment::PENDING;
        } else if ($transaction == 'deny') {
            // TODO set payment status in merchant's database to 'Denied'
            $paymentStatus = PAYMENT::DENY;
        } else if ($transaction == 'expire') {
            // TODO set payment status in merchant's database to 'expire'
            $paymentStatus = PAYMENT::EXPIRE;
        } else if ($transaction == 'cancel') {
            // TODO set payment status in merchant's database to 'Denied'
            $paymentStatus = PAYMENT::CANCEL;
        }


        $paymentParams = [
            'order_code' => $order->order_code,
            // 'number' => Payment::generateCode(),
            'amount' => $paymentNotification->gross_amount,
            'method' => 'midtrans',
            'status' => $paymentStatus,
            'token' => $paymentNotification->transaction_id,
            'payloads' => $payload,
            'payment_type' => $paymentNotification->payment_type,
            'va_number' => $vaNumber,
            'vendor_name' => $vendorName,
            'biller_code' => $paymentNotification->biller_code,
            'bill_key' => $paymentNotification->bill_key,
        ];

        $payment = Payment::create($paymentParams);

        if ($paymentStatus && $payment) {
            if (in_array($payment->status, [Payment::SUCCESS, Payment::SETTLEMENT])) {
                Order::where([
                    ['order_code', $paymentNotification->order_id],
                    ['is_delivered', 1]
                ])->update([
                    'is_paid' => 1,
                ]);
            }
        }

        $message = 'Payment status is : ' . $paymentStatus;

        $response = [
            'code' => 200,
            'message' => $message,
        ];

        return response($response, 200);
    }

    public function completed(Request $request)
    {
        $orderCode = $request->query('order_id');
        $order = Order::where([
            ['order_code', $orderCode],
            ['is_delivered', 1],
        ])->pluck('is_paid')->toArray();

        $orderDone = Order::where([
            ['order_code', $orderCode],
        ])->pluck('is_done')->toArray();

        // dd($orderDone);

        if (empty($order)) {
            return abort(404);
        }

        if (in_array(1, $orderDone)) {
            return abort(404);
        }

        if (in_array(0, $order)) {
            return redirect('payments/failed?order_id=' . $orderCode);
        }

        Order::where([
            ['order_code', $orderCode]
        ])->update([
            'is_done' => 1,
        ]);

        Table::where([
            ['table_number', '=', Auth::user()->table_number]
        ])->update([
            'customer_name' => null
        ]);

        session()->flash('success', 'Thank you for completing the payment process!');

        return redirect('/paymentsPage/' . $orderCode);
    }

    public function failed(Request $request)
    {
        $orderCode = $request->query('order_id');

        $order = Order::where([
            ['order_code', $orderCode],
            ['is_delivered', 1],
        ])->pluck('is_paid')->toArray();

        $orderDone = Order::where([
            ['order_code', $orderCode],
        ])->pluck('is_done')->toArray();

        // dd($orderDone, $order);

        if (empty($order)) {
            return abort(404);
        }

        if (in_array(1, $orderDone)) {
            return abort(404);
        }

        if (in_array(1, $order)) {
            return abort(404);
        }

        Order::where([
            ['order_code', $orderCode]
        ])->update([
            'is_paid' => 0,
            'is_ready_to_be_paid' => 0,
            'order_code' => null,
            'payment_type' => null,
            'payment_token' => null,
            'payment_url' => null,
            'is_done' => 0,
        ]);

        session()->flash('error', "Sorry, we couldn't process your payment.");

        return redirect('/paymentsPage/' . $orderCode);
    }

    public function unfinish(Request $request)
    {
        $orderCode = $request->query('order_id');

        $order = Order::where([
            ['order_code', $orderCode],
            ['is_delivered', 1],
        ])->pluck('is_paid')->toArray();

        $orderDone = Order::where([
            ['order_code', $orderCode],
        ])->pluck('is_done')->toArray();

        // dd($orderDone);

        if (empty($order)) {
            return abort(404);
        }

        if (in_array(1, $orderDone)) {
            return abort(404);
        }

        if (in_array(1, $order)) {
            return abort(404);
        }

        Order::where([
            ['order_code', $orderCode]
        ])->update([
            'is_paid' => 0,
            'is_ready_to_be_paid' => 0,
            'order_code' => null,
            'payment_type' => null,
            'payment_token' => null,
            'payment_url' => null,
            'is_done' => 0,
        ]);

        session()->flash('error', "Sorry, we couldn't process your payment.");

        return redirect('/paymentsPage/' . $orderCode);
    }

    public function paymentPage(Request $request)
    {
        // dd($request->session()->all());
        if (!$request->session()->has('error') && !$request->session()->has('success')) {
            return abort(404);
        }
        return view('order.paymentsPage', compact('request'));
    }
}
