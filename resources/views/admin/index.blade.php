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
                                    <h5 class="text-uppercase text-white m-0">FRAMES<span class="pull-right">{{ number_format($totalAmount, 0, '.', ',') }} RWF</span>
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
                                    <h5 class="text-uppercase text-white m-0">LENS<span class="pull-right">{{ number_format($totalAmount1, 0, '.', ',') }}
                                            RWF</span>
                                    </h5>
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
                                    <span class="pull-right">
                                        {{ number_format($totalAmount2, 0, '.', ',') }} RWF
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
                                <h5 class="text-uppercase text-white m-0">

                                    <span class="pull-right">Active: {{ $buyerCount }}</span>
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
                        <h4 class="pull-left page-title">Lens</h4>
                        <canvas id="purchaseChart" width="400" height="200"></canvas>
                        <div>
                            <button onclick="updateChart('daily')">Daily</button>
                            <button onclick="updateChart('weekly')">Weekly</button>
                            <button onclick="updateChart('monthly')">Monthly</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-sm-12">
                        <h4 class="pull-left page-title">Frames</h4>
                        <canvas id="salesChart" width="400" height="200"></canvas>
                        <div>
                            <button onclick="updateChart('daily')">Daily</button>
                            <button onclick="updateChart('weekly')">Weekly</button>
                            <button onclick="updateChart('monthly')">Monthly</button>
                        </div>
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
        labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
        datasets: [{
            label: 'Sales',
            data: [0, 59, 80, 81, 56, 55, 40, 0],
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    };

    // Dummy data for purchase chart
    const purchaseData = {
        labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
        datasets: [{
            label: 'Sales',
            data: [35, 43, 70, 71, 46, 45, 30],
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
        type: 'line',
        data: purchaseData,
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

    // Function to update charts based on selected timeframe
    function updateChart(timeframe) {
        // You can implement logic here to fetch data for the selected timeframe
        // For now, I'll just update the labels for demonstration
        let newLabels;
        switch (timeframe) {
            case 'daily':
                newLabels = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                break;
            case 'weekly':
                newLabels = ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5'];
                break;
            case 'monthly':
                newLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                break;
        }
        // Update labels for both charts
        salesChart.data.labels = newLabels;
        purchaseChart.data.labels = newLabels;
        // Update charts
        salesChart.update();
        purchaseChart.update();
    }
</script>
@endsection