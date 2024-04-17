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
                <div class="row">
                    <a href="list">
                        <div class="col-md-6 col-sm-6 col-lg-3">
                            <div class="mini-stat clearfix bx-shadow bg-info">
                                <span class="mini-stat-icon"><i class="fa fa-bars"></i></span>
                                <div class="mini-stat-info text-right">
                                    <span class="counter">

                                        6

                                    </span>
                                    Active Items
                                </div>
                                <div class="tiles-progress">
                                    <div class="m-t-20">
                                        <h5 class="text-uppercase text-white m-0">ADD NEW ITEMS<span
                                                class="pull-right"></span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a href="#">
                        <div class="col-md-6 col-sm-6 col-lg-3">
                            <div class="mini-stat clearfix bg-purple bx-shadow">
                                <span class="mini-stat-icon"><i class="ion-ios7-cart"></i></span>
                                <div class="mini-stat-info text-right">
                                    <span class="counter">
                                        200 Rwf
                                    </span>
                                    WORTH
                                </div>
                                <div class="tiles-progress">
                                    <div class="m-t-20">
                                        <h5 class="text-uppercase text-white m-0">PURCHASE AND SELL<span class="pull-right">
                                                50</span></h5>
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
                                    60
                                </span>
                                Transactions
                            </div>
                            <div class="tiles-progress">
                                <div class="m-t-20">
                                    <h5 class="text-uppercase text-white m-0">From
                                        <span class="pull-right">
                                            10 Suppliers
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
                                50
                                <span class="counter">50</span>
                                Customers
                            </div>
                            <div class="tiles-progress">
                                <div class="m-t-20">
                                    <h5 class="text-uppercase text-white m-0">From
                                        50
                                        <span class="pull-right">5 Stores</span>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- container -->

        </div> <!-- content -->

    </div>
@endsection
