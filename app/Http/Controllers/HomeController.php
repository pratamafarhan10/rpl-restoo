<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function rekapitulasiHarian()
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

        $allTimeRanks = Order::where([
            ['is_paid', 1],
        ])->with('food')->select(DB::raw("SUM(total_delivered) as total_pendapatan"), "food_id")->groupBy(DB::raw("food_id"))->orderBy('total_pendapatan', 'DESC')->get();

        $todayRanks = Order::where([
            ['is_paid', 1],
        ])->with('food')->select(DB::raw("SUM(total_delivered) as total_pendapatan"), "food_id")->groupBy(DB::raw("food_id"))->orderBy('total_pendapatan', 'DESC')->whereDate('created_at', Carbon::today())->get();

        $todaySales = Order::where([
            ['is_paid', 1],
        ])->whereDate('created_at', Carbon::today())->sum('total_delivered');

        $yesterdaySales = Order::where([
            ['is_paid', 1],
        ])->whereDate('created_at', Carbon::yesterday())->sum('total_delivered');

        $allTimeSales = Order::where([
            ['is_paid', 1],
        ])->sum('total_delivered');

        $todayIncome = Order::where([
            ['is_paid', 1],
        ])->whereDate('created_at', Carbon::today())->sum('total_price');

        $yesterdayIncome = Order::where([
            ['is_paid', 1],
        ])->whereDate('created_at', Carbon::yesterday())->sum('total_price');

        $allTimeIncome = Order::where([
            ['is_paid', 1],
        ])->sum('total_price');

        $thisMonth = Carbon::now()->month;
        $lastMonth = 1;
        $twoMonth = 2;
        $threeMonth = 3;
        $fourMonth = 4;
        $thisYear = Carbon::now()->year;

        $thisMonthSales = Order::where([
            ['is_paid', 1],
        ])->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->sum('total_delivered');

        $lastMonthSales = Order::where([
            ['is_paid', 1],
        ])->whereMonth('created_at', $this->monthCounter($thisMonth, $lastMonth, $thisYear)[0])->whereYear('created_at', $this->monthCounter($thisMonth, $lastMonth, $thisYear)[1])->sum('total_delivered');

        $thisMonthIncome =
            [
                Order::where([
                    ['is_paid', 1],
                ])->whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->sum('total_price'),
                Carbon::now()->format('F')
            ];

        $lastMonthIncome = [Order::where([
            ['is_paid', 1],
        ])->whereMonth('created_at', $this->monthCounter($thisMonth, $lastMonth, $thisYear)[0])->whereYear('created_at', $this->monthCounter($thisMonth, $lastMonth, $thisYear)[1])->sum('total_price'), $this->monthCounter($thisMonth, $lastMonth, $thisYear)[2]];

        $twoMonthIncome = [Order::where([
            ['is_paid', 1],
        ])->whereMonth('created_at', $this->monthCounter($thisMonth, $twoMonth, $thisYear)[0])->whereYear('created_at', $this->monthCounter($thisMonth, $twoMonth, $thisYear)[1])->sum('total_price'), $this->monthCounter($thisMonth, $twoMonth, $thisYear)[2]];

        $threeMonthIncome = [Order::where([
            ['is_paid', 1],
        ])->whereMonth('created_at', $this->monthCounter($thisMonth, $threeMonth, $thisYear)[0])->whereYear('created_at', $this->monthCounter($thisMonth, $threeMonth, $thisYear)[1])->sum('total_price'), $this->monthCounter($thisMonth, $threeMonth, $thisYear)[2]];
        
        $salesPercentage = ($lastMonthSales == 0) ? 0 : (float)number_format((($thisMonthSales - $lastMonthSales) / $lastMonthSales) * 100, 2, '.', '');

        $incomePercentage = ($lastMonthIncome[0] == 0) ? 0 : (float)number_format((($thisMonthIncome[0] - $lastMonthIncome[0]) / $lastMonthIncome[0]) * 100, 2, '.', '');

        // dd($salesPercentage, $thisMonthSales, $lastMonthSales);        

        return view('home.harian.index', compact('allTimeRanks', 'todayRanks', 'todaySales', 'yesterdaySales', 'allTimeSales', 'todayIncome', 'yesterdayIncome', 'allTimeIncome', 'sapa', 'thisMonthIncome', 'lastMonthIncome', 'twoMonthIncome', 'threeMonthIncome', 'salesPercentage', 'incomePercentage'));
    }

    public function monthCounter($now, $previous, $year)
    {
        if ($now - $previous <= 0) {
            $count = $now - $previous;
            $month = 12 + $count;
            $year -= 1;
        } else {
            $month = $now - $previous;
        }

        $date = Carbon::create($year, $month, 15);

        $monthName = $date->format('F');

        return [$month, $year, $monthName];
    }

    public function rekapitulasiPerMenu($id)
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

        $food = Food::find($id);

        $todaySales = Order::where([
            ['is_paid', 1],
            ['food_id', $id],
        ])->whereDate('created_at', Carbon::today())->sum('total_delivered');

        $yesterdaySales = Order::where([
            ['is_paid', 1],
            ['food_id', $id],
        ])->whereDate('created_at', Carbon::yesterday())->sum('total_delivered');

        $allTimeSales = Order::where([
            ['is_paid', 1],
            ['food_id', $id],
        ])->sum('total_delivered');

        $todayIncome = Order::where([
            ['is_paid', 1],
            ['food_id', $id],
        ])->whereDate('created_at', Carbon::today())->sum('total_price');

        $yesterdayIncome = Order::where([
            ['is_paid', 1],
            ['food_id', $id],
        ])->whereDate('created_at', Carbon::yesterday())->sum('total_price');

        $allTimeIncome = Order::where([
            ['is_paid', 1],
            ['food_id', $id],
        ])->sum('total_price');

        $thisMonth = Carbon::now()->month;
        $lastMonth = 1;
        $twoMonth = 2;
        $threeMonth = 3;
        $fourMonth = 4;
        $thisYear = Carbon::now()->year;

        // Penjualan
        $thisMonthSales =
            [
                Order::where([
                    ['is_paid', 1],
                    ['food_id', $id],
                ])->whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->sum('total_delivered'),
                Carbon::now()->format('F')
            ];

        $lastMonthSales = [Order::where([
            ['is_paid', 1],
            ['food_id', $id],
        ])->whereMonth('created_at', $this->monthCounter($thisMonth, $lastMonth, $thisYear)[0])->whereYear('created_at', $this->monthCounter($thisMonth, $lastMonth, $thisYear)[1])->sum('total_delivered'), $this->monthCounter($thisMonth, $lastMonth, $thisYear)[2]];

        $twoMonthSales = [Order::where([
            ['is_paid', 1],
            ['food_id', $id],
        ])->whereMonth('created_at', $this->monthCounter($thisMonth, $twoMonth, $thisYear)[0])->whereYear('created_at', $this->monthCounter($thisMonth, $twoMonth, $thisYear)[1])->sum('total_delivered'), $this->monthCounter($thisMonth, $twoMonth, $thisYear)[2]];

        $threeMonthSales = [Order::where([
            ['is_paid', 1],
            ['food_id', $id],
        ])->whereMonth('created_at', $this->monthCounter($thisMonth, $threeMonth, $thisYear)[0])->whereYear('created_at', $this->monthCounter($thisMonth, $threeMonth, $thisYear)[1])->sum('total_delivered'), $this->monthCounter($thisMonth, $threeMonth, $thisYear)[2]];

        // Pendapatan
        $thisMonthIncome =
            [
                Order::where([
                    ['is_paid', 1],
                    ['food_id', $id],
                ])->whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->sum('total_price'),
                Carbon::now()->format('F')
            ];

        $lastMonthIncome = [Order::where([
            ['is_paid', 1],
            ['food_id', $id],
        ])->whereMonth('created_at', $this->monthCounter($thisMonth, $lastMonth, $thisYear)[0])->whereYear('created_at', $this->monthCounter($thisMonth, $lastMonth, $thisYear)[1])->sum('total_price'), $this->monthCounter($thisMonth, $lastMonth, $thisYear)[2]];

        $twoMonthIncome = [Order::where([
            ['is_paid', 1],
            ['food_id', $id],
        ])->whereMonth('created_at', $this->monthCounter($thisMonth, $twoMonth, $thisYear)[0])->whereYear('created_at', $this->monthCounter($thisMonth, $twoMonth, $thisYear)[1])->sum('total_price'), $this->monthCounter($thisMonth, $twoMonth, $thisYear)[2]];

        $threeMonthIncome = [Order::where([
            ['is_paid', 1],
            ['food_id', $id],
        ])->whereMonth('created_at', $this->monthCounter($thisMonth, $threeMonth, $thisYear)[0])->whereYear('created_at', $this->monthCounter($thisMonth, $threeMonth, $thisYear)[1])->sum('total_price'), $this->monthCounter($thisMonth, $threeMonth, $thisYear)[2]];

        $salesPercentage = ($lastMonthSales[0] == 0) ? 0 : (float)number_format((($thisMonthSales[0] - $lastMonthSales[0]) / $lastMonthSales[0]) * 100, 2, '.', '');

        $incomePercentage = ($lastMonthIncome[0] == 0) ? 0 : (float)number_format((($thisMonthIncome[0] - $lastMonthIncome[0]) / $lastMonthIncome[0]) * 100, 2, '.', '');

        return view('home.menu.index', compact('food', 'todaySales', 'yesterdaySales', 'allTimeSales', 'todayIncome', 'yesterdayIncome', 'allTimeIncome', 'sapa', 'thisMonthIncome', 'lastMonthIncome', 'twoMonthIncome', 'threeMonthIncome', 'salesPercentage', 'incomePercentage', 'thisMonthSales', 'lastMonthSales', 'twoMonthSales', 'threeMonthSales'));
    }

    public function redirectLogin()
    {
        return redirect('/login');
    }
}