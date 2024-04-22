@extends('layouts.app')

@section('page-title')
    {{ __('Dashboard') }}
@endsection

@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">

                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="pull-left page-title"><b>REMAIN IN STOCK </b><i class="ion-ios7-cart-outline"></i></h3>

                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-success">
                            <div class="panel-heading" style="background-color:#3e4550;">
                                <h3 class="panel-title" style="color: #ffffff;">
                                    VALUE OF xxxxx RWF Remain in your stock</h3>
                            </div>
                            <div class="panel-body">
                                <div id="itamePlace">
                                    <table id="datatable-buttons" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>N/O</th>
                                                <th>Item Name</th>
                                                <th>Quantity</th>
                                                <th>Unit Measure</th>
                                                <th>Unity Price</th>
                                                <th>Outstanding</th>
                                                <th class="hidden-print">Actions</th>
                                            </tr>
                                        </thead>


                                        <tbody>


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> 

            </div> 

        </div> 
    </div>

    <div class="modal fade bs-example-modal-lg" id="itemHist" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none">
        <div class="modal-dialog modal-lg">
            <div class="modal-content p-0 b-0">
                <div id="itemInfoPop">
                    <div class="panel panel-color panel-primary">
                        <div class="panel-heading">
                            Loadding...</div>
                        <div class="panel-body">

                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="loader"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-right">
                                        <div id="printInvoice">
                                            <button type="button" class="btn btn-danger waves-effect"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><
    </div>
@endsection
