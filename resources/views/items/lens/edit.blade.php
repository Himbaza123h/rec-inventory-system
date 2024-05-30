@extends('layouts.app')

@section('page-title')
    {{ __('Edit Item') }}
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
                            <li><a href="{{ route('admin.items.lens.index') }}">Lenses</a></li>
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
                                        <h3 class="panel-title">Edit Item Information</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel-body">
                                        <form action="{{ route('admin.item.lens.update', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="mark_lens">Category of Lens</label><br>
                                                    <select name="mark_lens" id="mark_lens" class="select2 form-control">
                                                        <option value="">Category of Lens</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}"
                                                                {{ $item->mark_lens == $category->id ? 'selected' : '' }}>
                                                                {{ $category->category_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="lens_attribute">Type</label><br>
                                                    <select name="type_name" id="type_name" class="select2 form-control">
                                                        <option value="">Select Type</option>
                                                        @foreach ($types as $type)
                                                            <option value="{{ $type->id }}"
                                                                {{ $item->item_type == $type->id ? 'selected' : '' }}>
                                                                {{ $type->type_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>


                                                <div class="col-md-4">
                                                    <label for="lens_attribute">Lens Attribute</label><br>
                                                    <select name="lens_attribute" id="lens_attribute"
                                                        class="select2 form-control">
                                                        <option value="">Select Attribute</option>
                                                        @foreach ($attributes as $attribute)
                                                            <option value="{{ $attribute->id }}"
                                                                {{ $item->lens_attribute == $attribute->id ? 'selected' : '' }}>
                                                                {{ $attribute->attribute_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="col-md-3">
                                                        <select name="sph" class="select2 form-control">
                                                            <option value="">SPH</option>
                                                            <option value="{{ $item->power_sph }}"
                                                                {{ $item->power_sph ? 'selected' : '' }}>
                                                                {{ $item->power_sph }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <select name="syl" class="select2 form-control">
                                                            <option value="">SYL</option>
                                                            <option value="{{ $item->power_cyl }}"
                                                                {{ $item->power_cyl ? 'selected' : '' }}>
                                                                {{ $item->power_cyl }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <select name="axis" class="select2 form-control">
                                                            <option value="">AXIS</option>
                                                            <option value="{{ $item->power_axis }}"
                                                                {{ $item->power_axis ? 'selected' : '' }}>
                                                                {{ $item->power_axis }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <select name="add_" class="select2 form-control">
                                                            <option value="">ADD</option>
                                                            <option value="{{ $item->power_add }}"
                                                                {{ $item->power_add ? 'selected' : '' }}>
                                                                {{ $item->power_add }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="price" id="price" class="form-control"
                                                        placeholder="Price" value="{{ $item->price }}">
                                                </div>
                                            </div><br>
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
