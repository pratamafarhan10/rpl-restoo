<?php

namespace App\Widgets;

use App\Models\Order;
use Arrilot\Widgets\AbstractWidget;

class TimDapur extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];
    public $reloadTimeout = 5;

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        // Get order
        $orders = Order::where([
            ['is_done', '=', 0],
            ['is_ready_to_be_paid', '=', 0],
        ])->oldest()->get();

        return view('widgets.tim_dapur', [
            'config' => $this->config,
            'orders' => $orders,
        ]);
    }
}
