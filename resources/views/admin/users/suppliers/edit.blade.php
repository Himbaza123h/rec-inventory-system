@extends('layouts.app')

@section('page-title')
    {{ __('Edit User') }}
@endsection


@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="pull-left page-title"><b>SUPPLIERS</b></h4>
                        <ol class="breadcrumb pull-right">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route('admin.suppliers.index') }}">Suppliers</a></li>
                            <li class="active">Edit</li>
                        </ol>
                    </div>
                </div>



                <div class="row">

                    <div class="col-lg-8">
                        <div class="panel panel-default">
                            <div class="panel-heading" id="usersList">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="panel-title">Edit User Information</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel-body">
                                        <form action="{{ route('admin.supplier.update', $user->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="row">
                                                <div class="col-md-6">
                                                    Names<br />
                                                    <input type="text" name="supplier_name" id="name"
                                                        class="form-control input-sm" placeholder="New User"
                                                        value="{{ $user->supplier_name }}"><br />
                                                </div>
                                                <div class="col-md-6">
                                                    Tin Number<br />
                                                    <input type="text" required name="supplier_tin_number" id="supplier_tin_number"
                                                        class="form-control input-sm" placeholder="TIN NUMBER"
                                                        value="{{ $user->supplier_tin_number }}"><br />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    Email Address<br />
                                                    <input type="text" name="supplier_email" id="Phone"
                                                        class="form-control input-sm" placeholder="email@example.com"
                                                        value="{{ $user->supplier_email }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    Phone Number<br />
                                                    <input type="text" name="supplier_phone" id="Phone"
                                                        class="form-control input-sm" placeholder="07********"
                                                        value="{{ $user->supplier_phone }}">
                                                </div>
                                                <div class="col-md-6">
                                                    Address<br />
                                                    <input type="text" name="supplier_work_place" id="customer_address"
                                                        class="form-control input-sm" placeholder="kigali | Rwanda"
                                                        value="{{ $user->supplier_work_place }}">
                                                </div>
                                            </div> <br>
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
