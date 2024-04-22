@extends('layouts.app')

@section('page-title')
    {{ __('Item Speed') }}
@endsection


@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="pull-left page-title">Faster moving or Slower moving Items</h4>

                    </div>
                </div>


                <div class="row">
                    <!-- USER LIST -->
                    <div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="panel-title">STATISTICS</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div id="userResurts" class="inbox-widget nicescroll mx-box">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>N/O</th>
                                                <th>ITEM CODE</th>
                                                <th>SALE COUNT</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($items as $index => $item)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $item->category->category_name }} {{ $item->code }}</td>
                                                    <td>
                                                        {{ $item->sale_count }}
                                                    </td>


                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>


                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                    <!-- RESULT TABLE -->
                    <div class="col-lg-8">
                        <div class="panel panel-default">
                            <div class="panel-heading" id="header1">
                                <div class="row">
                                    <div class="col-md-3">
                                        <h3 class="panel-title">ITEM Name</h3>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <input type="date" onchange="between()" id="fromDate"
                                                class="form-control input-sm" min="" placeholder="mm/dd/yyyy">
                                            <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <h3 class="panel-title">
                                            <center><i class="ion-arrow-right-c"></i></center>
                                        </h3>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <input type="date" onchange="between()" id="toDate"
                                                class="form-control input-sm" placeholder="mm/dd/yyyy">
                                            <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div id="fmcgReport" class="inbox-widget nicescroll mx-box">
                                    <h5 class="text-success">
                                        <center>Click on the Item If You Made any transaction
                                        </center>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                </div>
            </div> <!-- container -->

        </div> <!-- content -->


    </div>
@endsection
