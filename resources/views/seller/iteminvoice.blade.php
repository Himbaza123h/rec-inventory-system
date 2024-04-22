@extends('layouts.app')

@section('page-title')
    {{ __('Dashboard') }}
@endsection


@section('content')
    <div class="container">
        <div class="content-page">
            <!-- Start content -->
            <div class="content">
                <div class="container">

                    <!-- Page-Title -->

                    <div class="row">
                        <!-- USER LIST -->
                        <div class="col-lg-3 hidden-print">
                            <div class="panel panel-inverse">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h4 class="panel-title" style="color: #fff;">INVOICES: {{ $sale->id }}</h4>
                                        </div>

                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div id="userResurts" class="inbox-widget nicescroll mx-box">
                                        <table>
                                            <tbody>
                                                    <tr>
                                                        <td><a href="{{ route('seller.invoice.index')}}"><i class="fa fa-chevron-left"></i> Back </a> </td>
                                                    </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end col -->
                        <div class="col-md-9">
                            <div class="panel panel-default">
                                <div class="panel-body" id="detailsSection">
                                    <!-- Details section will be dynamically updated here -->
                                </div>
                            </div>
                        </div>

                        <div class="col-md-9">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <table border="1" width="100%">
                                        <tr>
                                            <th colspan="7">
                                                <h4 class="text-center">QUATATION</h4>
                                                <div class="clearfix">
                                                    <div class="pull-left">
                                                        <strong>ELECTRICOM</strong><br>
                                                        <strong>Address: KK 15rd Silverback Mall <br>Rwanda</strong><br>
                                                        <strong>Mobile: 0788760101</strong><br>
                                                        <strong>Email: electricom06@yahoo.fr</strong><br>
                                                        <strong>VAT Number: 101394902</strong><br>
                                                    </div>
                                                    <div class="pull-right">
                                                        <img src="assets/images/electric.jpg" height="100" width="200"
                                                            alt="Electricom Ltd">
                                                    </div>
                                                </div>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th rowspan="6" colspan="3">
                                                <p class="text-center">Customer Details</p>
                                                <strong>Name:</strong><br>
                                                <strong>Mobile: </strong><br>
                                            </th>
                                            <th colspan="4">Item name:{{ $sale->product }} </th>
                                        </tr>
                                        <tr>
                                            <th colspan="4">Item Code:{{ $sale->item_code }}  </th>
                                        </tr>
                                        <tr>
                                            <th colspan="4">Color:{{ $sale->color }}  </th>
                                        </tr>
                                        <tr>
                                            <th colspan="4">Size:{{ $sale->color }}  </th>
                                        </tr>
                                        <tr>
                                            <th colspan="4">Reference No.:{{ $sale->id }}  </th>
                                        </tr>
                                        <tr>
                                            <th colspan="4">Date:{{ $sale->created_at}} </th>
                                        </tr>
                                        <tr>
                                            <th colspan="4">Sales Man: {{ auth()->user()->name }}</th>
                                        </tr>
                                        <tr style="height:20px">
                                            <th colspan="7"></th>
                                        </tr>
                                        <tr>
                                            <th>#</th>
                                            <th>DESCRIPTION</th>
                                            <th>QTY</th>
                                            <th>Price</th>
                                            <th>TOTAL</th>
                                            <th>DISCOUNT</th>
                                        </tr>
                                        <tr>
                                            <td>{{ $sale->id }}</td>
                                            <td>{{ $sale->product }} // {{ $sale->item_code }}</td>
                                            <td>{{ $sale->qty }}</td>
                                            <td>{{ $sale->price }}</td>
                                            <td>{{ $sale->total }}</td>
                                            <td>{{ $sale->discount }}</td>
                                        </tr>
                                        <tr>
                                            <th rowspan="3" colspan="5"></th>
                                            <th>
                                                TOTAL
                                            </th>
                                            <th>
                                                <strong>{{ $sale->total }} RWF
                                                </strong>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>VAT</th>
                                            <th>
                                                {{ $sale->vat }}
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>GRAND TOTAL</th>
                                            <th>
                                                <strong>
                                                    {{ $grandTotal }}
                                                </strong>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="7">
                                                Bank of Kigali 00049-06933931-72/RWF<br>
                                                Account Name: ELECTRICOM LTD<br>
                                                Department of Administrative and Finance<br>
                                                ELECTRICOM
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
                                        <a href="javascript:window.print()"
                                            class="btn btn-inverse waves-effect waves-light"><i class="fa fa-print"></i></a>
                                        <a href="#" class="btn btn-primary waves-effect waves-light">Submit</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- container -->
        </div>

    </div>

@endsection
