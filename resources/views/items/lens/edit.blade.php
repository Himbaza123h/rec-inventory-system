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
                                                <div class="col-md-6">
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
                                                <div class="col-md-6">
                                                    <label for="lens_attribute">Lens Attribute</label><br>
                                                    <select name="lens_attribute" id="lens_attribute"
                                                        class="select2 form-control">
                                                        <option value="">Select Attribute</option>
                                                        <option value="1"
                                                            {{ $item->lens_attribute == 1 ? 'selected' : '' }}>White
                                                        </option>
                                                        <option value="2"
                                                            {{ $item->lens_attribute == 2 ? 'selected' : '' }}>PhotoChromic
                                                        </option>
                                                        <option value="3"
                                                            {{ $item->lens_attribute == 3 ? 'selected' : '' }}>White BlueCat
                                                        </option>
                                                        <option value="4"
                                                            {{ $item->lens_attribute == 4 ? 'selected' : '' }}>PhotoChromic
                                                            BlueCat</option>
                                                    </select>
                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="col-md-3">
                                                        <select name="sph" class="select2 form-control">
                                                            <option value="">SPH</option>
                                                            <option value="{{ $item->power?->sph }}"
                                                                {{ $item->power?->sph ? 'selected' : '' }}>
                                                                {{ $item->power?->sph }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <select name="syl" class="select2 form-control">
                                                            <option value="">SYL</option>
                                                            <option value="{{ $item->power?->syl }}"
                                                                {{ $item->power?->syl ? 'selected' : '' }}>
                                                                {{ $item->power?->syl }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <select name="axis" class="select2 form-control">
                                                            <option value="">AXIS</option>
                                                            <option value="{{ $item->power?->axis }}"
                                                                {{ $item->power?->axis ? 'selected' : '' }}>
                                                                {{ $item->power?->axis }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <select name="add_" class="select2 form-control">
                                                            <option value="">ADD</option>
                                                            <option value="{{ $item->power?->add_ }}"
                                                                {{ $item->power?->add_ ? 'selected' : '' }}>
                                                                {{ $item->power?->add_ }}</option>
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
