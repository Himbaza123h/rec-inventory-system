@extends('layouts.app')
@section('page-title')
    {{ __('Customers') }}
@endsection


@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="pull-left page-title"><b>CUSTOMERS</b></h4>
                        <ol class="breadcrumb pull-right">
                            <li><a href="#">Home</a></li>
                            <li class="active">Customers</li>
                        </ol>
                    </div>
                </div>



                <div class="row">
                    <!-- USER LIST -->
                    <div class="col-lg-8" style="height: 200px">
                        <div id="userdiv">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4 class="panel-title">New Customer</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <form action="{{ route('seller.customer.append.store') }}" method="POST">
                                        @csrf
                                        <div class="inbox-widget nicescroll mx-box">
                                            <div class="col-md-6">

                                                Customer Name<br />
                                                <input type="text" name="customer_name" id="name"
                                                    class="form-control input-sm" placeholder="Customer Name"><br />
                                            </div>
                                            <input type="hidden" value="{{ $saleCode }}" name="number_hidden">
                                            <div class="col-md-6">

                                                Phone<br />
                                                <input type="numbers" name="customer_phone" id="Phone"
                                                    class="form-control input-sm" placeholder="Phone Number"><br /> <br>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">

                                                    Address<br />
                                                    <input type="text" name="customer_address" id="WorkPlace"
                                                        class="form-control input-sm" placeholder="Kigali-Remera"><br />
                                                </div>
                                                <div class="col-md-6">

                                                    @php
                                                        $insurances = \App\Models\Insurance::where(
                                                            'status',
                                                            true,
                                                        )->get();
                                                    @endphp
                                                    Insurance<br />
                                                    <select name="insurance_id" id="" class="form-control select2">
                                                        <option value="">Select Insurance</option>
                                                        @foreach ($insurances as $item)
                                                            <option value="{{ $item->id }}">{{ $item->insurance_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <br>
                                                </div>
                                            </div>
                                            <br>
                                            <button type="submit" class="btn btn-success waves-effect waves-light">Add
                                                Customer</button>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->


                </div> <!-- End Row -->

            </div> <!-- container -->

        </div> <!-- content -->

    </div>
@endsection
