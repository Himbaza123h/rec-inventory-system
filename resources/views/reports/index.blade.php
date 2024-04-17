@extends('layouts.app')

@section('page-title')
    {{ __('Reports') }}
@endsection


@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="pull-left page-title">GENERAL REPORT</h4>
                    </div>
                </div>

                <div class="row">
                    <!-- RESULT TABLE -->
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" id="userName">

                                <div class="row">
                                    <div class="col-md-2">
                                        <select class="select2 form-control storeId" data-placeholder="Choose Category..."
                                            name="storeId" id="storeId">
                                            <option>Select Product</option>
                                            <option value="sunglasses">SunGlasses</option>
                                            <option value="lens">Lens</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                        <h3 class="panel-title">
                                            <center> From</center>
                                        </h3>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="input-group">
                                            <input type="date" id="fromDate" class="form-control input-sm"
                                                placeholder="mm/dd/yyyy">
                                            <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <h3 class="panel-title">
                                            <center>TO</center>
                                        </h3>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group">
                                            <input type="date" id="toDate" class="form-control input-sm"
                                                placeholder="mm/dd/yyyy">
                                            <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <h3 class="panel-title">
                                            <center>
                                                <button class="btn btn-primary" onclick="filtering()"
                                                    type="submit">Filter</button>
                                            </center>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div id="userReport" class="inbox-widget nicescroll mx-box">
                                    <table id="datatable-buttons" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>N/O</th>
                                                <th>Stock</th>
                                                <th>Item Name</th>
                                                <th>Quantity</th>
                                                <th>Unit Measure</th>
                                                <th>Unity Price</th>
                                                <th>Operation</th>
                                                <th>Total</th>
                                                <th>Date</th>
                                                <th>By</th>
                                                <th>Description</th>
                                            </tr>
                                        </thead>


                                        <tbody>



                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                </div> <!-- End Row -->


            </div> <!-- container -->

        </div> <!-- content -->
    </div>
@endsection
