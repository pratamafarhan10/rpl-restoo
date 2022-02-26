<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Food;
use App\Models\Order;
use App\Models\Table;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // // Sapa selamat
        // date_default_timezone_set('asia/jakarta');
        // $bb = time();
        // $hour = date("G", $bb);
        // if ($hour > 3 && $hour <= 10) {
        //     $sapa = "Selamat pagi";
        // } elseif ($hour > 10 && $hour < 15) {
        //     $sapa = "Selamat siang";
        // } elseif ($hour >= 15 && $hour < 18) {
        //     $sapa = "Selamat sore";
        // } else {
        //     $sapa = "Selamat malam";
        // }

        // // Menampilkan pesanan
        $table = Table::where('table_number', Auth::user()->table_number)->get()[0];
        $orders = Order::where([
            ['table_number', '=', Auth::user()->table_number],
            ['is_done', '=', 0],
            ['is_ready_to_be_paid', '=', 0],
        ])->get();

        $totalOrderPrice = Order::where([
            ['table_number', '=', Auth::user()->table_number],
            ['is_done', '=', 0],
            ['is_ready_to_be_paid', '=', 0],
            ['is_delivered', '=', 1],
        ])->select(DB::raw('sum(total_delivered * price_qty) as total'))->get()[0];

        // dd($totalOrderPrice->total);

        return view('order.index', compact('orders', 'totalOrderPrice', 'table'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $foods = Food::where('is_hidden', 0)->get();
        $categories = Category::get();

        return view('order.create', compact('foods', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate request
        $request->validate([
            'food_id' => 'array|required',
            'total' => 'array|required',
        ]);

        // Ambil request
        $attr = $request->all();

        // Get nama customer
        $table = Table::where('table_number', Auth::user()->table_number)->get()[0];

        // insert ke tabel order
        for ($i = 0; $i < count($attr['food_id']); $i++) {
            $getFood = Food::where('id', $attr['food_id'][$i])->get()->toArray()[0];
            if ($attr['total'][$attr['food_id'][$i]] !== '0') {
                Order::create([
                    'table_number' => Auth::user()->table_number,
                    'customer_name' => $table->customer_name,
                    'food_id' => $attr['food_id'][$i],
                    'total_order' => $attr['total'][$attr['food_id'][$i]],
                    'price_qty' => $getFood['price'],
                    'total_price' => 0,
                    'is_delivered' => 0,
                    'is_ready_to_be_paid' => 0,
                    'is_paid' => 0,
                    'is_done' => 0,
                    'total_delivered' => 0,
                ]);
            }
        }

        return redirect('/pemesanan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $orders = Order::where([
            ['table_number', '=', Auth::user()->table_number],
            ['is_done', '=', 0],
            ['is_ready_to_be_paid', '=', 0],
            ['order_code', '=', null],
        ])->get();

        $categories = Category::get();

        return view('order.edit', compact('orders', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        // validate request
        $request->validate([
            'total' => 'array|required',
            'code' => 'required'
        ]);

        if ($request->code !== 'updatemenu') {
            session()->flash('error', 'Kode yang dimasukkan salah');
            return redirect('/updatepesanan');
        }

        $attr = $request->total;

        // dd($attr);

        // update ke tabel order
        for ($i = array_key_first($attr); $i <= array_key_last($attr); $i++) {
            $getOrder = Order::where('id', $i)->get()->toArray()[0];
            // dd($attr[$i] == 0);
            if ($attr[$i] !== '0') {
                Order::where('id', $i)->update([
                    'is_delivered' => 1,
                    'total_delivered' => $getOrder['total_delivered'] + $attr[$i],
                    'total_price' => ($getOrder['total_delivered'] + $attr[$i]) * $getOrder['price_qty'],
                ]);
            }
        }

        return redirect('/pemesanan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    public function payment(Request $request)
    {
        $request->validate([
            'payment_type' => 'required',
        ]);

        $orderCode = uniqid();
        Order::where([
            ['table_number', '=', Auth::user()->table_number],
            ['is_done', '=', 0],
            ['is_ready_to_be_paid', '=', 0],
            ['order_code', '=', null],
        ])->update([
            'is_ready_to_be_paid' => 1,
            'payment_type' => $request->payment_type,
            'order_code' => $orderCode,
        ]);

        // dd($request->all());

        if ($request->payment_type == 'cash') {
            session()->flash('success', 'Thank you for completing your order, please go to the cashier');

            Table::where([
                ['table_number', '=', Auth::user()->table_number],
            ])->update([
                'customer_name' => null,
            ]);

            return redirect('/paymentsPage/' . $orderCode);
        } elseif ($request->payment_type == 'online') {
            // Ambil data pemesanan per meja
            $orderList = Order::where([
                ['is_ready_to_be_paid', 1],
                ['order_code', '=', $orderCode],
                ['is_paid', 0],
                ['is_done', 0],
                ['is_delivered', 1],
            ])->get()->groupBy('order_code')->first();

            $totalPrice = array_sum(array_column($orderList->toArray(), 'total_price'));

            // dd($totalPrice);

            $paymentURL = $this->_generatePaymentToken($orderCode, $totalPrice);

            return redirect($paymentURL);
        }
    }

    private function _generatePaymentToken($orderCode, $totalPrice)
    {
        $this->initPaymentGateway();
        // $params = array(
        //     'transaction_details' => array(
        //         'order_id' => $orderCode,
        //         'gross_amount' => $totalPrice,
        //     )
        // );

        $params = [
            'enabled_payments' => [
                "bca_va", "bni_va", "bri_va", "gopay", "shopeepay",
            ],
            'transaction_details' => [
                'order_id' => $orderCode,
                'gross_amount' => $totalPrice,
            ],
        ];

        // dd($params);
        $snap = \Midtrans\Snap::createTransaction($params);

        // Update url dan token
        $orderList = Order::where([
            ['order_code', '=', $orderCode],
        ])->update([
            'payment_token' => $snap->token,
            'payment_url' => $snap->redirect_url,
        ]);

        try {
            // Get Snap Payment Page URL
            // $paymentUrl = \Midtrans\Snap::createTransaction($params)->redirect_url;

            // Redirect to Snap Payment Page
            return $snap->redirect_url;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
