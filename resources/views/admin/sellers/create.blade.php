@extends('layouts.app')

@section('page-title')
    {{ __('Edit Seller') }}
@endsection


@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="pull-left page-title"><b>ITEMS</b></h4>
                        <ol class="breadcrumb pull-right">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route('admin.sellers.index') }}">Sellers</a></li>
                            <li class="active">Seller</li>
                        </ol>
                    </div>
                </div>


                <div class="row">

                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading" id="usersList">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="panel-title">Edit Seller</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel-body">
                                        <form action="{{ route('admin.seller.update', $data->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            Seller Name<br />
                                            <input type="text" name="seller_name" id="" class="form-control"
                                                placeholder="Seller Name" value="{{ $data->seller_name }}"><br />

                                            Seller Phone<br />
                                            <input type="text" name="seller_phone" id="" class="form-control"
                                                placeholder="Seller Phone" value="{{ $data->seller_phone }}"><br />

                                            <button type="submit" class="btn btn-success waves-effect waves-light">UPDATE
                                                <i class="fa fa-save"></i></button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div> <!-- End Row -->

            </div> <!-- container -->

        </div> <!-- content -->


    </div>
@endsection
