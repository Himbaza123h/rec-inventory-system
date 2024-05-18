@extends('layouts.app')

@section('page-title')
{{ __('Dashboard') }}
@endsection


@section('content')
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">

            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="pull-left page-title">WELCOME !</h4>

                </div>
            </div>
            <!-- Start Widget -->
            @php
            $itemSold = \App\Models\Sale::where('product_id', 1)->count();
            $itemSold1 = \App\Models\Sale::where('product_id', 2)->count();
            @endphp


            <div class="row">
                <a href="{{ route('seller.make.sales.index') }}">
                    <div class="col-md-6 col-sm-6 col-lg-4">
                        <div class="mini-stat clearfix bg-purple bx-shadow">
                            <span class="mini-stat-icon"><i class="ion-ios7-cart"></i></span>
                            <div class="mini-stat-info text-right">
                                <span class="counter">
                                    {{ $itemSold }}
                                </span>
                                SOLD
                            </div>
                            <div class="tiles-progress">
                                <div class="m-t-20">
                                    <h5 class="text-uppercase text-white m-0">Frames<span class="pull-right">
                                        </span></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="{{ route('seller.make.sales.index') }}">
                    <div class="col-md-6 col-sm-6 col-lg-4">
                        <div class="mini-stat clearfix bg-primary bx-shadow">
                            <span class="mini-stat-icon"><i class="ion-ios7-cart"></i></span>
                            <div class="mini-stat-info text-right">
                                <span class="counter">
                                    {{ $itemSold1 }}
                                </span>
                                SOLD
                            </div>
                            <div class="tiles-progress">
                                <div class="m-t-20">
                                    <h5 class="text-uppercase text-white m-0">Lens<span class="pull-right">
                                        </span></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div> <!-- container -->
        <div class="container" style="margin-top: 20px; margin-left:10px;">
            <div class="row">
                <div class="col-md-6">
                    <div class="col-sm-12">
                        <h4 class="pull-left page-title">Frames Sales Today</h4>
                        <canvas id="framesSalesChart" width="400" height="200"></canvas>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-sm-12">
                        <h4 class="pull-left page-title">Lens Sales Today</h4>
                        <canvas id="lensSalesChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- content -->

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Function to create a chart
    function createChart(chartId, data, label) {
        const ctx = document.getElementById(chartId).getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($hoursLabels) !!},
                datasets: [{
                    label: label,
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                animation: {
                    duration: 2000, 
                    easing: 'easeOutBounce'
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    }

    // Create frames sales chart
    createChart('framesSalesChart', {!! json_encode($framesData) !!}, 'Frames Sales');

    // Create lens sales chart
    createChart('lensSalesChart', {!! json_encode($lensData) !!}, 'Lens Sales');
</script>
@endsection
