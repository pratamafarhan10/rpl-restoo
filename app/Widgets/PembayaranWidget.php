<?php

namespace App\Widgets;

use App\Models\Order;
use Arrilot\Widgets\AbstractWidget;

class PembayaranWidget extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];
    public $reloadTimeout = 60;

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        // Ambil data pemesanan per meja
        $paymentLists = Order::where([
            ['is_ready_to_be_paid', 1],
            ['order_code', '!=', null],
            ['is_paid', 0],
            ['is_done', 0],
            ['is_delivered', 1]
        ])->get()->groupBy('order_code');

        return view('widgets.pembayaran_widget', [
            'config' => $this->config,
            'paymentLists' => $paymentLists,
        ]);
    }
}
