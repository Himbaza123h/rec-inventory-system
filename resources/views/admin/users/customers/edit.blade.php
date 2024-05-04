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
                        <h4 class="pull-left page-title"><b>CUSTOMER USERS</b></h4>
                        <ol class="breadcrumb pull-right">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route(auth()->user()->role . '.customers.index') }}">Customers</a></li>
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
                                        <form action="{{ route(auth()->user()->role . '.customer.update', $user->id) }}"
                                            method="POST">

                                            @csrf
                                            @method('PUT')
                                            <div class="row">
                                                <div class="col-md-6">
                                                    Names<br />
                                                    <input type="text" name="customer_name" id="name"
                                                        class="form-control input-sm" placeholder="New User"
                                                        value="{{ $user->customer_name }}"><br />
                                                </div>
                                                <div class="col-md-6">
                                                    Tin Number<br />
                                                    <input type="text" required name="customer_tin_number"
                                                        id="customer_tin_number" class="form-control input-sm"
                                                        placeholder="TIN NUMBER"
                                                        value="{{ $user->customer_tin_number }}"><br />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    Phone Number<br />
                                                    <input type="text" name="customer_phone" id="Phone"
                                                        class="form-control input-sm" placeholder="07********"
                                                        value="{{ $user->customer_phone }}">
                                                </div>
                                                <div class="col-md-4">
                                                    Address<br />
                                                    <input type="text" name="customer_address" id="customer_address"
                                                        class="form-control input-sm" placeholder="kigali | Rwanda"
                                                        value="{{ $user->customer_address }}">
                                                </div>

                                            <div class="col-md-4">
                                                Insurance <br />
                                                @php
                                                    $insurances = \App\Models\Insurance::where('status', true)->get();
                                                @endphp
                                                <select name="insurance_id" id="" class="form-control select2">
                                                    <option value="">Select Insurance</option>
                                                    @foreach ($insurances as $item)
                                                        <option value="{{ $item->id }}">{{ $item->insurance_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            </div>


                                            <br>
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
