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
                        <h4 class="pull-left page-title"><b>SYSTEM USERS</b></h4>
                        <ol class="breadcrumb pull-right">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route('admin.users.index') }}">Users</a></li>
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
                                        <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
                                            @csrf
                                            @method('PUT') <!-- Use method spoofing for PUT requests -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    User Name<br />
                                                    <input type="text" name="name" id="name"
                                                        class="form-control input-sm" placeholder="New User"
                                                        value="{{ $user->name }}"><br />
                                                </div>
                                                <div class="col-md-6">
                                                    Phone Number<br />
                                                    <input type="text" name="phone" id="Phone"
                                                        class="form-control input-sm" placeholder="07********"
                                                        value="{{ $user->phone }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    Email Address<br />
                                                    <input type="email" required name="email" id="Email"
                                                        class="form-control input-sm" placeholder="example@gmail.com"
                                                        value="{{ $user->email }}"><br />
                                                </div>
                                                <div class="col-md-6">
                                                    User Type<br>
                                                    <select class="form-control select2" id="userType" name="role">
                                                        <option>Select User Type</option>
                                                        <option value="admin"
                                                            {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                                        <option value="seller"
                                                            {{ $user->role === 'seller' ? 'selected' : '' }}>Seller (Main
                                                            Stock)</option>
                                                    </select><br />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    Password<br />
                                                    <input type="password" name="password" id="password"
                                                        class="form-control input-sm" placeholder="******"><br />
                                                </div>
                                                <div class="col-md-6">
                                                    Status<br>
                                                    <select class="form-control select2" id="userType" name="status">
                                                        <option>Select Status</option>
                                                        <option value="1" {{ $user->approved == 1 ? 'selected' : '' }}>Active</option>
                                                        <option value="0" {{ $user->approved == 0 ? 'selected' : '' }}>Inactive</option>
                                                    </select><br />
                                                </div>
                                            </div>
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
