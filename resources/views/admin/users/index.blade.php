@extends('layouts.app')
@section('page-title')
    {{ __('Users') }}
@endsection

@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="pull-left page-title"><b>SYSTEM USERS</b></h4>
                        <ol class="breadcrumb pull-right">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li class="active">Users</li>
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
                                            <h4 class="panel-title">New User</h4>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-body">
                                    <div class="inbox-widget nicescroll mx-box">
                                        <form action="{{ route('admin.user.store') }}" method="POST">
                                            @csrf
                                            User Name<br />
                                            <input type="text" name="name" id="name"
                                                class="form-control input-sm" placeholder="New User"><br />
                                            Phone Number<br />
                                            <input type="numbers" name="phone" id="Phone"
                                                class="form-control input-sm" placeholder="07********"><br />
                                            Email Address<br />
                                            <input type="email" required name="email" id="Email"
                                                class="form-control input-sm" placeholder="example@gmail.com"><br />
                                            User Type<br>
                                            <select class="form-control select2" id="userType" name="role">
                                                <option>Select User Type</option>
                                                <option value="admin">Admin</option>
                                                <option value="seller">Seller (Main Stock)</option>
                                            </select><br /><br>
                                            Password<br />
                                            <input type="password" name="password" id="password"
                                                class="form-control input-sm" placeholder="******"><br />
                                            <button type="submit" class="btn btn-success waves-effect waves-light">ADD <i
                                                    class="fa fa-plus"></i></button>
                                        </form>
                                    </div>
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
                                        <h3 class="panel-title">List of Users</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div id="listTable" class="inbox-widget nicescroll mx-box">
                                    <table width="100%" class="table table-striped table-bordered">
                                        <thead>
                                            <th>#</th>
                                            <th>names</th>
                                            <th>phone</th>
                                            <th>email</th>
                                            <th>Type</th>
                                            <th>Actions</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $index => $item)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->phone }}</td>
                                                    <td>{{ $item->email }}</td>
                                                    <td>{{ $item->role }}</td>
                                                    <td>
                                                        <span class="btn btn-primary rounded p-2">
                                                            <a href="{{ route('admin.user.edit', [$item->id]) }}"
                                                                style="text-decoration: none"
                                                                class="t-decoration-none text-white">{{ __('edit') }}</a>
                                                        </span>

                                                        <span class="btn btn-danger rounded p-2 m-2">
                                                            <a href="{{ route('admin.user.delete', ['id' => $item->id]) }}"
                                                                onclick="event.preventDefault();
                                                                     if (confirm('Are you sure you want to delete this user?')) {
                                                                         document.getElementById('delete-form-{{ $item->id }}').submit();
                                                                     }"
                                                                style="text-decoration: none"
                                                                class="text-white">{{ __('delete') }}</a>
                                                        </span>
                                                        <form id="delete-form-{{ $item->id }}"
                                                            action="{{ route('admin.user.delete', ['id' => $item->id]) }}"
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
