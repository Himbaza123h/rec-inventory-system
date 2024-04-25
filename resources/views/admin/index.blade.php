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
                    $item = \App\Models\Item::count();
                    $lens = \App\Models\Lens::count();
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
                                        {{ $item }}
                                    </span>
                                    Active Items
                                </div>
                                <div class="tiles-progress">
                                    <div class="m-t-20">
                                        <h5 class="text-uppercase text-white m-0">ADD NEW GLASS<span
                                                class="pull-right"></span></h5>
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
                                        {{ $lens }}
                                    </span>
                                    Active Items
                                </div>
                                <div class="tiles-progress">
                                    <div class="m-t-20">
                                        <h5 class="text-uppercase text-white m-0">ADD NEW LENS<span
                                                class="pull-right"></span></h5>
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
                                    {{ $purchaseCount }}
                                </span>
                                Transactions
                            </div>
                            <div class="tiles-progress">
                                <div class="m-t-20">
                                    <h5 class="text-uppercase text-white m-0">From
                                        <span class="pull-right">
                                            {{ $activeSuppliersCount }} Suppliers
                                        </span>
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
                                    <h5 class="text-uppercase text-white m-0">From

                                        <span class="pull-right">1 Store</span>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- container -->



            <div class="container" style="margin-top: 20px; margin-left:10px;">
                <div class="row">
                    <div class="col-md-6">
                        <div class="col-sm-12">
                            <h4 class="pull-left page-title">Sales Chart</h4>
                            <canvas id="salesChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="col-sm-12">
                            <h4 class="pull-left page-title">Purchase Chart</h4>
                            <canvas id="purchaseChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- content -->

    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Dummy data for sales chart
        const salesData = {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
                label: 'Sales',
                data: [65, 59, 80, 81, 56, 55, 40],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        };

        // Dummy data for purchase chart
        const purchaseData = {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
                label: 'Purchases',
                data: [35, 49, 70, 71, 46, 45, 30],
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        };

        // Get canvas elements
        const salesChartCanvas = document.getElementById('salesChart');
        const purchaseChartCanvas = document.getElementById('purchaseChart');

        // Create charts
        const salesChart = new Chart(salesChartCanvas, {
            type: 'line',
            data: salesData,
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        const purchaseChart = new Chart(purchaseChartCanvas, {
            type: 'line', // Changed to line chart
            data: salesData,
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        },
                        gridLines: {
                            color: 'rgba(0, 0, 0, 0.1)' // Customize grid line color
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            display: false // Disable x-axis grid lines
                        }
                    }]
                },
                elements: {
                    line: {
                        tension: 0.3, // Adjust line tension for smoother curves
                        backgroundColor: 'rgba(54, 162, 235, 0.2)', // Set background color for line
                        borderColor: 'rgba(54, 162, 235, 1)', // Set border color for line
                        borderWidth: 2 // Set border width for line
                    },
                    point: {
                        backgroundColor: 'rgba(54, 162, 235, 1)', // Set background color for points
                        borderColor: 'rgba(54, 162, 235, 1)', // Set border color for points
                        borderWidth: 2, // Set border width for points
                        radius: 4 // Set radius for points
                    }
                },
                plugins: {
                    filler: {
                        propagate: true // Propagate fill to the start of the data
                    }
                }
            }
        });
    </script>
@endsection
