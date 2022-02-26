@extends('layouts.app', ['title' => 'Dashboard'])

@section('content')
<div class="container-md mb-5">

    <div class="row mt-3">
        <h1 class="title-fitur">{{$sapa}}, <strong>Manajer</strong></h1>
    </div>

    <div class="row mt-3">
        <h1 class="right-order-content-price">Statistik <strong>Penjualan</strong></h1>
    </div>

    <div class="row mt-3">
        <div class="col">
            <div id="piechart" style="height: 300px;"></div>
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
                    @elseif( $salesPercentage < 0 )
                    <p class="dashboard-word">Penjualan : <strong style="color: #FD3127; font-size : 32px">-{{ $salesPercentage }}%</strong></p>
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
                    <p class="dashboard-word">Pendapatan : <strong style="color: #FD3127; font-size : 32px">-{{ $incomePercentage }}%</strong></p>
                    <p class="dasboard-word">from last month</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">

        <div class="col">
            <div class="card dashboard-card" style="width: 18rem;">
                <div class="card-header dashboard-leaderboard-title-alltime">
                    All Time Ranking
                </div>
                <ul class="list-group list-group-flush">
                    @forelse($allTimeRanks as $index => $alltimerank)
                    <li class="list-group-item dashboard-leaderboard"><strong>#{{ $index + 1}}</strong><a href="{{route('home.menu', $alltimerank->food_id)}}"> {{ $alltimerank->food->name }} {{ $index == 0 ? '🔥' : ''}}</a></li>
                    @empty
                    <li class="list-group-item dashboard-leaderboard text-center">There's no order yet</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="col">
            <div class="card dashboard-card" style="width: 18rem;">
                <div class="card-header dashboard-leaderboard-title-today">
                    Today Ranking
                </div>
                <ul class="list-group list-group-flush">
                    @forelse($todayRanks as $index => $todayrank)
                    <li class="list-group-item dashboard-leaderboard"><strong>#{{ $index + 1}}</strong><a href="{{route('home.menu', $todayrank->food_id)}}"> {{ $todayrank->food->name }} {{ $index == 0 ? '🔥' : ''}}</a></li>
                    @empty
                    <li class="list-group-item dashboard-leaderboard text-center">There's no order yet</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="col">
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

            <div class="row mt-2">
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


@javascript('allTimeRanks', $allTimeRanks)
@javascript('thisMonthIncome', $thisMonthIncome)
@javascript('lastMonthIncome', $lastMonthIncome)
@javascript('twoMonthIncome', $twoMonthIncome)
@javascript('threeMonthIncome', $threeMonthIncome)

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);
    google.charts.setOnLoadCallback(drawAreaChart);

    console.log(thisMonthIncome);

    function penjualan() {
        let arrayPenjualan = [
            ['Menu name', 'Total Pendapatan']
        ];
        allTimeRanks.slice(0, 4).forEach((e, i) => {
            arrayPenjualan.push([e.food.name, parseInt(e.total_pendapatan)])
        });

        return arrayPenjualan;
    }

    function drawChart() {

        var data = google.visualization.arrayToDataTable(penjualan());

        var options = {
            title: 'Penjualan Menu',
            titleTextStyle: {
                color: 'white'
            },
            backgroundColor: {
                fill: '#212936',
                opacity: 100
            },
            legend: {
                textStyle: {
                    color: 'white',
                }
            },
            is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

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
            title: 'Pendapatan',
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