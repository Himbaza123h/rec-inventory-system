@extends('layouts.app')

@section('page-title')
    {{ __('Categories') }}
@endsection


@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="pull-left page-title"><b>COLOR</b></h4>
                        <ol class="breadcrumb pull-right">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li class="active">Colors</li>
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
                                            <h4 class="panel-title"> New Color</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <form action="{{ route('admin.color.store') }}" method="POST">
                                        @csrf
                                        Color Code<br />
                                        <input type="text" name="color_name" id="" class="form-control"
                                            placeholder="Color Name"><br />
                                        <button type="submit" class="btn btn-success">Add
                                            Category</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RESULT TABLE -->
                    <div class="col-lg-8">
                        <div class="panel panel-default">
                            <div class="panel-heading" id="usersList">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="panel-title">List of Colors</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div id="listTable" class="inbox-widget nicescroll mx-box">
                                    <table width="100%" class="table table-striped table-bordered">
                                        <thead>
                                            <th>N/O</th>
                                            <th>Color Code</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </thead>

                                        <tbody>
                                            @foreach ($colors as $index => $color)
                                                <tr>
                                                    <td>
                                                        {{ $index + 1 }}
                                                    </td>
                                                    <td>
                                                        {{ $color->color_name }}
                                                    </td>
                                                    <td>
                                                        {{ $color->created_at->format('Y-m-d') }}
                                                    </td>
                                                    <td>
                                                        <span class="btn btn-primary rounded p-2">
                                                            <a href="{{ route('admin.color.edit', [$color->id]) }}"
                                                                style="text-decoration: none"
                                                                class="t-decoration-none text-white">{{ __('edit') }}</a>
                                                        </span>

                                                        <span class="btn btn-danger rounded p-2 m-2">
                                                            <a href="{{ route('admin.color.delete', ['id' => $color->id]) }}"
                                                                onclick="event.preventDefault();
                                                                     if (confirm('Are you sure you want to delete this color?')) {
                                                                         document.getElementById('delete-form-{{ $color->id }}').submit();
                                                                     }"
                                                                style="text-decoration: none"
                                                                class="text-white">{{ __('delete') }}</a>
                                                        </span>
                                                        <form id="delete-form-{{ $color->id }}"
                                                            action="{{ route('admin.color.delete', ['id' => $color->id]) }}"
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
