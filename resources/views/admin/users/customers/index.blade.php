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
                    <div class="col-lg-4">
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
                                    <form action="{{ route(auth()->user()->role . '.customer.store') }}" method="POST">
                                        @csrf
                                        <div class="inbox-widget nicescroll mx-box">
                                            Customer Name<br />
                                            <input type="text" name="customer_name" id="name"
                                                class="form-control input-sm" placeholder="Customer Name"><br />
                                            Tin Number<br />
                                            <input type="numbers" name="customer_tin_number" id="tinNumber"
                                                class="form-control input-sm" placeholder="Tin Number"><br />
                                            Phone<br />
                                            <input type="numbers" name="customer_phone" id="Phone"
                                                class="form-control input-sm" placeholder="Phone Number"><br />
                                            Address<br />
                                            <input type="text" name="customer_address" id="WorkPlace"
                                                class="form-control input-sm" placeholder="Kigali-Remera"><br />
                                            <button type="submit" class="btn btn-success waves-effect waves-light">Add
                                                Customer</button>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->


                    <!-- RESULT TABLE -->
                    <div class="col-lg-8">
                        <div class="panel panel-default">
                            <div class="panel-heading" id="usersList">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="panel-title">List of Customers</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div id="listTable" class="inbox-widget nicescroll mx-box">
                                    <table width="100%" class="table table-striped table-bordered">
                                        <thead>
                                            <th>#</th>
                                            <th>Names</th>
                                            <th>Tin Number</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>Actions</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $index => $item)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $item->customer_name }}</td>
                                                    <td>{{ $item->customer_tin_number }}</td>
                                                    <td>{{ $item->customer_phone }}</td>
                                                    <td>{{ $item->customer_address }}</td>
                                                    <td>
                                                        <span class="btn btn-primary rounded p-2">
                                                            <a href="{{ route(auth()->user()->role . '.customer.edit', [$item->id]) }}"
                                                                style="text-decoration: none"
                                                                class="t-decoration-none text-white">{{ __('edit') }}</a>
                                                        </span>

                                                        <span class="btn btn-danger rounded p-2 m-2">
                                                            <a href="{{ route(auth()->user()->role . '.customer.delete', ['id' => $item->id]) }}"
                                                                onclick="event.preventDefault();
                                                                         if (confirm('Are you sure you want to delete this customer?')) {
                                                                             document.getElementById('delete-form-{{ $item->id }}').submit();
                                                                         }"
                                                                style="text-decoration: none"
                                                                class="text-white">{{ __('delete') }}</a>
                                                        </span>
                                                        <form id="delete-form-{{ $item->id }}"
                                                            action="{{ route(auth()->user()->role . '.customer.delete', ['id' => $item->id]) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- End Row -->

            </div> <!-- container -->

        </div> <!-- content -->

    </div>
@endsection
