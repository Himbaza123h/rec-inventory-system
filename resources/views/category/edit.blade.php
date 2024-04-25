@extends('layouts.app')

@section('page-title')
    {{ __('Edit Category') }}
@endsection


@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="pull-left page-title"><b>CATEGORIES</b></h4>
                        <ol class="breadcrumb pull-right">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route('admin.category.index') }}">Category</a></li>
                            <li class="active">Edit</li>
                        </ol>
                    </div>
                </div>



                <div class="row">

                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading" id="usersList">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="panel-title">Edit Category Information</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel-body">
                                        <form action="{{ route('admin.category.update', $data->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            @php
                                                $products = \App\Models\Product::get();
                                            @endphp
                                            <select name="product" id="product" class="select2 form-control"
                                                placeholder="Select Product">
                                                <option value="">Select Product</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}"
                                                        {{ $product->id == $data->product ? 'selected' : '' }}>
                                                        {{ $product->id == 1 ? 'Glass' : ($product->id == 2 ? 'Lens' : $product->name) }}
                                                    </option>
                                                @endforeach
                                            </select><br /><br />
                                            Category Name<br />
                                            <input type="text" name="category_name" id="" class="form-control"
                                                placeholder="Category Name" value="{{ $data->category_name }}"><br />
                                            <br />

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
