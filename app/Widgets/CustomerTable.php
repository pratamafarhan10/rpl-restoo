<?php

namespace App\Widgets;

use App\Models\Table;
use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Facades\Auth;

class CustomerTable extends AbstractWidget
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
        // Sapa selamat
        date_default_timezone_set('asia/jakarta');
        $bb = time();
        $hour = date("G", $bb);
        if ($hour > 3 && $hour <= 10) {
            $sapa = "Selamat pagi";
        } elseif ($hour > 10 && $hour < 15) {
            $sapa = "Selamat siang";
        } elseif ($hour >= 15 && $hour < 18) {
            $sapa = "Selamat sore";
        } else {
            $sapa = "Selamat malam";
        }

        $table = Table::where('table_number', Auth::user()->table_number)->get()[0];

        return view('widgets.customer_table', [
            'config' => $this->config,
            'sapa' => $sapa,
            'table' => $table,
        ]);
    }
}
