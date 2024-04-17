@extends('layouts.app')
@section('page-title')
    {{ __('Suppliers') }}
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
                            <li><a href="#">Home</a></li>
                            <li class="active">Suppliers</li>
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
                                            <h4 class="panel-title">New Supplier</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <form action="{{ route('admin.supplier.store') }}" method="POST">
                                        @csrf
                                        <div class="inbox-widget nicescroll mx-box">
                                            Supplier Name<br />
                                            <input type="text" name="supplier_name" id="name"
                                                class="form-control input-sm" placeholder="Supplier Name"><br />
                                            Tin Number<br />
                                            <input type="numbers" name="supplier_tin_number" id="tinNumber"
                                                class="form-control input-sm" placeholder="Tin Number"><br />
                                            Phone<br />
                                            <input type="numbers" name="supplier_phone" id="Phone"
                                                class="form-control input-sm" placeholder="Phone Number"><br />
                                            Email<br />
                                            <input type="email" required name="supplier_email" id="Email"
                                                class="form-control input-sm" placeholder="example@gmail.com"><br />
                                            WorkPlace<br />
                                            <input type="text" name="supplier_work_place" id="WorkPlace"
                                                class="form-control input-sm" placeholder="Kigali-Rwanda"><br />
                                            <button type="submit" class="btn btn-success waves-effect waves-light">Add
                                                Supplier</button>
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
                                        <h3 class="panel-title">List of Suppliers</h3>
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
                                            <th>Email</th>
                                            <th>WorkPlace</th>
                                            <th>Actions</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $index => $item)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $item->supplier_name }}</td>
                                                    <td>{{ $item->supplier_tin_number }}</td>
                                                    <td>{{ $item->supplier_phone }}</td>
                                                    <td>{{ $item->supplier_email }}</td>
                                                    <td>{{ $item->supplier_work_place }}</td>
                                                    <td>
                                                        <span class="btn btn-primary rounded p-2">
                                                            <a href="" style="text-decoration: none"
                                                                class="t-decoration-none text-white">{{ __('edit') }}</a>
                                                        </span>

                                                        <span class="btn btn-danger rounded p-2 m-2">
                                                            <a href="{{ route('admin.supplier.delete', ['id' => $item->id]) }}"
                                                                onclick="event.preventDefault();
                                                                         if (confirm('Are you sure you want to delete this supplier?')) {
                                                                             document.getElementById('delete-form-{{ $item->id }}').submit();
                                                                         }"
                                                                style="text-decoration: none"
                                                                class="text-white">{{ __('delete') }}</a>
                                                        </span>
                                                        <form id="delete-form-{{ $item->id }}"
                                                            action="{{ route('admin.supplier.delete', ['id' => $item->id]) }}"
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
