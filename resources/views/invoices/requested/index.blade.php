@extends('layouts.app')
@section('page-title')
    {{ __('Requested Invoices') }}
@endsection

@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="pull-left page-title"><b>REQUESTED INVOICES</b></h4>
                        <ol class="breadcrumb pull-right">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li class="active">Invoices</li>
                        </ol>
                    </div>
                </div>
                <!-- Page-Title -->
                <div class="row">
                    <!-- USER LIST -->
                    <div class="col-lg-3 hidden-print">
                        <div class="panel panel-inverse">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h4 class="panel-title" style="color: #fff;">INVOICES</h4>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <input type="text" id="searchInvoice" onkeyup="search()"
                                                name="example-input1-group2" class="form-control input-sm"
                                                placeholder="Search...">
                                            <span class="input-group-btn">
                                                <button type="button"
                                                    class="btn-sm btn waves-effect waves-light btn-primary"><i
                                                        class="fa fa-search"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div id="userResurts" class="inbox-widget nicescroll mx-box">

                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->
                    <div class="col-md-9">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <table border="1" width="100%">
                                    <tr>
                                        <th colspan="7">
                                            <h4 class="text-center">QUATATION</h4>
                                            <div class="clearfix">
                                                <div class="pull-left">
                                                    <strong>REC</strong><br>
                                                    <strong>Address: KK 15rd <br>Rwanda</strong><br>
                                                    <strong>Mobile: 0782643555</strong><br>
                                                    <strong>Email: rec@yahoo.fr</strong><br>
                                                    <strong>VAT Number: </strong><br>
                                                </div>
                                                <div class="pull-right">
                                                    <!-- <img src="assets/images/electric.jpg" height="100" width="200" alt="Electricom Ltd"> -->
                                                </div>
                                            </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th rowspan="4" colspan="3">
                                            <p class="text-center">Customer Details</p>
                                            <strong>Name: HONORE</strong><br>
                                            <strong>Mobile: 078</strong><br>
                                            <strong>Tax Number: </strong><br>
                                        </th>
                                        <th colspan="4">Number: </th>
                                    </tr>
                                    <tr>
                                        <th colspan="4">Reference No.: NO </th>
                                    </tr>
                                    <tr>
                                        <th colspan="4">Date: 2-2-2000</th>
                                    </tr>
                                    <tr>
                                        <th colspan="4">Sales Man: SilverbackMall</th>
                                    </tr>
                                    <tr style="height:20px">
                                        <th colspan="7"></th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>DESCRIPTION</th>
                                        <th>UOM</th>
                                        <th>QTY</th>
                                        <th>U/P</th>
                                        <th>DISCOUNT</th>
                                        <th>TOTAL</th>
                                    </tr>

                                    <tr>
                                        <th rowspan="3" colspan="5"></th>
                                        <th>
                                            TOTAL
                                        </th>
                                        <th>
                                            <strong>
                                                5000 RWF
                                            </strong>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>VAT</th>
                                        <th>
                                            VAT: 18%
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>GRAND TOTAL</th>
                                        <th>
                                            <strong>
                                                100 RWF
                                            </strong>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="7">
                                            Bank of Kigali : <br>
                                            Account Name: REC LTD<br>
                                            Department of Administrative and Finance<br>
                                            REC
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="7">
                                            NOTE:<br>
                                        </th>
                                    </tr>
                                </table>
                            </div>
                            <hr>
                            <div class="hidden-print">
                                <div class="pull-right">
                                    <a href="javascript:window.print()" class="btn btn-inverse waves-effect waves-light"><i
                                            class="fa fa-print"></i></a>
                                    <!-- <a href="#" class="btn btn-primary waves-effect waves-light">Submit</a> -->
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div> <!-- container -->
    </div>
@endsection
