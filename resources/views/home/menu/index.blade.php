@extends('layouts.app', ['title' => 'Dashboard : ' . $food->name])

@section('content')
<div class="container-md mb-5">

    <div class="row mt-3">
        <h1 class="title-fitur">{{$sapa}}, <strong>Manajer</strong></h1>
    </div>

    <div class="row mt-3">
        <h1 class="right-order-content-price">Statistik Penjualan Menu : <strong>{{ $food->name }}</strong></h1>
    </div>

    <div class="row mt-3">
        <div class="card w-100 h-100">
            <div class="row g-0">
                <div class="col-md-3 d-flex align-self-center">
                    <img src="{{ asset($food->takeImage()) }}" class="img-menu">
                </div>
                <div class="col-md-9">
                    <div class="card-body">
                        <h4 class="card-title">{{ $food->name }}</h4>
                        <div class="row menu-desc">
                            <div class="container">
                                <div class="row">
                                    <p class="col-sm-2 lh-sm">Description</p>
                                    <p class="col-sm-10 lh-sm">{{Str::limit($food->description, 150)}}</p>
                                </div>
                                <div class="row">
                                    <p class="col-sm-2 lh-sm">Ingredients</p>
                                    <p class="col-sm-10 lh-sm">{{Str::limit($food->ingredients, 150)}}</p>
                                </div>
                                <div class="row">
                                    <p class="col-sm-2 lh-lg">Category</p>
                                    <p class="col-sm-10 lh-lg">{{ $food->category->category_name }}</p>
                                </div>
                                <div class="row">
                                    <p class="col-sm-2 lh-sm">Price</p>
                                    <p class="col-sm-10 lh-sm">Rp. @money($food->price)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col">
            <div id="curve_chart" style="height: 300px"></div>
        </div>
        <div class="col">
            <div id="chart_div" style="width: 100%; height: 300px;"></div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col">
            <div class="card dashboard-card mx-auto" style="width: 18rem;">
                <div class="card-body text-center">
                    @if($salesPercentage > 0)
                    <p class="dashboard-word">Penjualan : <strong style="color: #0DF900; font-size : 32px">+{{ $salesPercentage }}%</strong></p>
                    <p class="dasboard-word">from last month</p>
                    @elseif($salesPercentage == 0)
                    <p class="dashboard-word">Penjualan : <strong style="color: #FEB015; font-size : 32px">{{ $salesPercentage }}%</strong></p>
                    <p class="dasboard-word">from last month</p>
                    @elseif($salesPercentage < 0) <p class="dashboard-word">Penjualan : <strong style="color: #FD3127; font-size : 32px">{{ $salesPercentage }}%</strong></p>
                    <p class="dasboard-word">from last month</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card dashboard-card mx-auto" style="width: 18rem;">
                <div class="card-body text-center">
                    @if($incomePercentage > 0)
                    <p class="dashboard-word">Pendapatan : <strong style="color: #0DF900; font-size : 32px">+{{ $incomePercentage }}%</strong></p>
                    <p class="dasboard-word">from last month</p>
                    @elseif($incomePercentage == 0)
                    <p class="dashboard-word">Pendapatan : <strong style="color: #FEB015; font-size : 32px">{{ $incomePercentage }}%</strong></p>
                    <p class="dasboard-word">from last month</p>
                    @elseif($incomePercentage < 0)
                    <p class="dashboard-word">Pendapatan : <strong style="color: #FD3127; font-size : 32px">{{ $incomePercentage }}%</strong></p>
                    <p class="dasboard-word">from last month</p>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <div class="row mt-3 justify-content-around">
        <div class=" col-5">
            <div class="row">
                <h1 class="right-order-content-price"><strong>Penjualan</strong></h1>
            </div>
            <div class="row align-items-center">
                <div class="col-md-3">
                    <img src="{{ asset('img/icon/penjualan.png') }}" style="height: 75px;">
                </div>
                <div class="col-md-9">
                    <div class="card dashboard-card">
                        <div class="card-body">
                            <p class="dashboard-word">Hari ini : <strong>{{ $todaySales }} Order</strong></p>
                        </div>
                    </div>
                    <div class="card dashboard-card mt-2">
                        <div class="card-body">
                            <p class="dashboard-word">Kemarin : <strong>{{ $yesterdaySales }} Order</strong></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <p class="dashboard-word">Total Penjualan : <strong>{{ $allTimeSales }} Order</strong></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-5">
            <div class="row">
                <h1 class="right-order-content-price"><strong>Pendapatan</strong></h1>
            </div>
            <div class="row align-items-center">
                <div class="col-md-3">
                    <img src="{{ asset('img/icon/pendapatan.png') }}" style="height: 75px;">
                </div>
                <div class="col-md-9">
                    <div class="card dashboard-card">
                        <div class="card-body">
                            <p class="dashboard-word">Hari ini : <strong>Rp. @money($todayIncome)</strong></p>
                        </div>
                    </div>
                    <div class="card dashboard-card mt-2">
                        <div class="card-body">
                            <p class="dashboard-word">Kemarin : <strong>Rp. @money($yesterdayIncome)</strong></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <p class="dashboard-word">Total Pendapatan : <strong>Rp. @money($allTimeIncome)</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@javascript('foodName', $food->name)
@javascript('thisMonthIncome', $thisMonthIncome)
@javascript('lastMonthIncome', $lastMonthIncome)
@javascript('twoMonthIncome', $twoMonthIncome)
@javascript('threeMonthIncome', $threeMonthIncome)

@javascript('thisMonthSales', $thisMonthSales)
@javascript('lastMonthSales', $lastMonthSales)
@javascript('twoMonthSales', $twoMonthSales)
@javascript('threeMonthSales', $threeMonthSales)

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);
    google.charts.setOnLoadCallback(drawAreaChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Month', 'Penjualan'],
            [threeMonthSales[1], parseInt(threeMonthSales[0])],
            [twoMonthSales[1], parseInt(twoMonthSales[0])],
            [lastMonthSales[1], parseInt(lastMonthSales[0])],
            [thisMonthSales[1], parseInt(thisMonthSales[0])],
        ]);

        var options = {
            title: 'Penjualan menu ' + foodName,
            curveType: 'function',
            hAxis: {
                titleTextStyle: {
                    color: '#fff'
                },
                textStyle: {
                    color: 'white'
                },
                gridlines: {
                    color: 'white'
                }
            },
            vAxis: {
                minValue: 0,
                textStyle: {
                    color: 'white'
                },
                gridlines: {
                    color: 'white'
                }
            },
            legend: {
                position: 'bottom',
                textStyle: {
                    color: 'white',
                }
            },
            colors: ['#4287f5', '#4287f5'],
            backgroundColor: {
                fill: '#212936',
                opacity: 100
            },
            titleTextStyle: {
                color: 'white'
            },
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
    }

    function drawAreaChart() {
        var data = google.visualization.arrayToDataTable([
            ['Month', 'Income'],
            [threeMonthIncome[1], parseInt(threeMonthIncome[0])],
            [twoMonthIncome[1], parseInt(twoMonthIncome[0])],
            [lastMonthIncome[1], parseInt(lastMonthIncome[0])],
            [thisMonthIncome[1], parseInt(thisMonthIncome[0])],
        ]);

        var options = {
            title: 'Pendapatan menu ' + foodName,
            hAxis: {
                title: 'Month',
                titleTextStyle: {
                    color: '#fff'
                },
                textStyle: {
                    color: 'white'
                },
                gridlines: {
                    color: 'white'
                }
            },
            vAxis: {
                minValue: 0,
                textStyle: {
                    color: 'white'
                },
                gridlines: {
                    color: 'white'
                }
            },
            backgroundColor: {
                fill: '#212936',
                opacity: 100
            },
            titleTextStyle: {
                color: 'white'
            },
            legend: {
                textStyle: {
                    color: 'white',
                }
            },
            colors: ['#4287f5', '#4287f5']
        };

        var areaChart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        areaChart.draw(data, options);
    }
</script>

@endsection