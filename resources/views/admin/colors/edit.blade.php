@extends('layouts.app')

@section('page-title')
    {{ __('Edit Color') }}
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
                            <li><a href="{{ route('admin.colors.index') }}">Color</a></li>
                            <li class="active">Color</li>
                        </ol>
                    </div>
                </div>


                <div class="row">

                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading" id="usersList">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="panel-title">Edit Color Information</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel-body">
                                        <form action="{{ route('admin.color.update', $color->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            Color Code<br />
                                            <input type="text" name="color_name" id="" class="form-control"
                                                placeholder="Color Name" value="{{ $color->color_name }}"><br />

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
