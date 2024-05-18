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
                        <h4 class="pull-left page-title">WELCOME {{ Auth::user()->name }}</h4>
                    </div>
                </div>
                <!-- Start Widget -->
                @php
                    $itemSold = \App\Models\Sale::where('product_id', 1)->count();
                    $totalAmount = \App\Models\CartItem::where('product_id', 1)->where('status', 2)->sum('amount');
                    $itemSold1 = \App\Models\Sale::where('product_id', 2)->count();
                    $totalAmount1 = \App\Models\CartItem::where('product_id', 2)->where('status', 2)->sum('amount');

                    $itemSold2 = \App\Models\Sale::count();
                    $totalAmount2 = \App\Models\CartItem::where('status', 2)->sum('amount');

                    $buyerCount = \App\Models\Sale::distinct('buyer_id')->count('buyer_id');

                    $purchase = \App\Models\Purchase::where('status', 2);
                    $purchaseCount = $purchase->count();
                    $activeSupplierIds = \App\Models\Purchase::pluck('supplier')->unique()->toArray();
                    $activeSuppliers = \App\Models\Supplier::whereIn('id', $activeSupplierIds)->get();
                    $activeSuppliersCount = $activeSuppliers->count();
                    $customers = \App\Models\Customer::count();
                @endphp
                <div class="row">
                    <a href="{{ route('admin.items.index') }}">
                        <div class="col-md-6 col-sm-6 col-lg-3">
                            <div class="mini-stat clearfix bx-shadow bg-info">
                                <span class="mini-stat-icon"><i class="fa fa-bars"></i></span>

                                <div class="mini-stat-info text-right">
                                    <span class="counter">
                                        {{ $itemSold }}
                                    </span>
                                    SOLD
                                </div>
                                <div class="tiles-progress">
                                    <div class="m-t-20">
                                        <h5 class="text-uppercase text-white m-0">FRAMES<span
                                                class="pull-right">{{ number_format($totalAmount, 0, '.', ',') }} RWF</span>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('admin.items.lens.index') }}">
                        <div class="col-md-6 col-sm-6 col-lg-3">
                            <div class="mini-stat clearfix bx-shadow bg-purple">
                                <span class="mini-stat-icon"><i class="fa fa-bars"></i></span>

                                <div class="mini-stat-info text-right">
                                    <span class="counter">
                                        {{ $itemSold1 }}
                                    </span>
                                    SOLD
                                </div>
                                <div class="tiles-progress">
                                    <div class="m-t-20">
                                        <h5 class="text-uppercase text-white m-0">LENS<span
                                                class="pull-right">{{ number_format($totalAmount1, 0, '.', ',') }}
                                                RWF</span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <div class="col-md-6 col-sm-6 col-lg-3">
                        <div class="mini-stat clearfix bg-success bx-shadow">
                            <span class="mini-stat-icon"><i class="ion-android-contacts"></i></span>
                            <div class="mini-stat-info text-right">
                                <span class="counter">
                                    {{ $itemSold2 }}
                                </span>
                                Transactions
                            </div>
                            <div class="tiles-progress">
                                <div class="m-t-20">
                                    <h5 class="text-uppercase text-white m-0">
                                        <span class="pull-right">{{ number_format($totalAmount2, 0, '.', ',') }} RWF</span>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-3">
                        <div class="mini-stat clearfix bg-primary bx-shadow">
                            <span class="mini-stat-icon"><i class="ion-android-contacts"></i></span>
                            <div class="mini-stat-info text-right">
                                <span class="counter">{{ $customers }}</span>
                                @if ($customers > 1)
                                    Customers
                                @else
                                    Customer
                                @endif
                            </div>
                            <div class="tiles-progress">
                                <div class="m-t-20">
                                    <h5 class="text-uppercase text-white m-0">
                                        <span <span class="pull-right">Active: {{ $buyerCount }}</span>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="container" style="margin-top: 20px; margin-left:10px;">
                <div class="row">

                    {{-- By  Year --}}

                    <div class="col-sm-6" style="margin-bottom: 10px">
                        <div class="row" style="color: #ffffff;">
                            <div class="col-md-4">
                                <div class="color" style="color: #000">Select Date</div>
                                <input type="date" id="filterDate" class="form-control">
                            </div>
                            <div class="col-md-2" style="margin-top: 20px">
                                <button id="filterBtnDate" class="btn btn-primary">Filter</button>
                            </div>
                        </div>
                    </div>
                    {{-- By Months  --}}

                    <div class="col-sm-6" style="margin-bottom: 10px">
                        
                    </div>

                </div>
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
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Function to create a chart
        function createChart(chartId, data, label) {
            const ctx = document.getElementById(chartId).getContext('2d');
            return new Chart(ctx, {
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
                                min: 0,
                                max: 100
                            }
                        }]
                    }
                }
            });
        }

        // Function to update the chart with new data
        function updateChart(chartInstance, chartId, data, label) {
            if (chartInstance) {
                chartInstance.destroy(); // Destroy the existing chart instance
            }
            chartInstance = createChart(chartId, data, label); // Create a new chart instance
            return chartInstance; // Return the new chart instance
        }

        $(document).ready(function() {
            let framesChart = null;
            let lensChart = null;

            // Initial chart creation
            framesChart = createChart('framesSalesChart', {!! json_encode($framesData) !!}, 'Frames Sales');
            lensChart = createChart('lensSalesChart', {!! json_encode($lensData) !!}, 'Lens Sales');

            $('#filterBtnYear').click(function() {
                var selectedYear = $('#year').val();

                // Make an AJAX request with selected year
                $.ajax({
                    url: "{{ route('admin.filterData') }}",
                    method: 'GET',
                    data: {
                        year: selectedYear,
                    },
                    success: function(data) {
                        // Update charts with filtered data
                        framesChart = updateChart(framesChart, 'framesSalesChart', data.framesData, 'Frames Sales');
                        lensChart = updateChart(lensChart, 'lensSalesChart', data.lensData, 'Lens Sales');
                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    }
                });
            });

            $('#filterBtnDate').click(function() {
                var selectedDate = $('#filterDate').val();

                // Make an AJAX request with selected date
                $.ajax({
                    url: "{{ route('admin.filterData') }}",
                    method: 'GET',
                    data: {
                        date: selectedDate,
                    },
                    success: function(data) {
                        // Update charts with filtered data
                        framesChart = updateChart(framesChart, 'framesSalesChart', data.framesData, 'Frames Sales');
                        lensChart = updateChart(lensChart, 'lensSalesChart', data.lensData, 'Lens Sales');
                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    }
                });
            });
        });
        
    </script>
@endsection
