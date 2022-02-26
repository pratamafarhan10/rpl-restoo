<?php

namespace App\Widgets;

use App\Models\Table;
use Arrilot\Widgets\AbstractWidget;

class WaiterSeat extends AbstractWidget
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
        $tables = Table::all();

        return view('widgets.waiter_seat', [
            'config' => $this->config,
            'tables' => $tables
        ]);
    }
}
