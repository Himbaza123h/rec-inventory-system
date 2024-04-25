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

                                            @php
                                                $categories = \App\Models\Category::where('product', 2)->get();
                                            @endphp
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="mark_lens">Category of Lens</label><br>
                                                    <select name="mark_lens" id="mark_lens" class="select2 form-control">
                                                        <option value="">Category of Lens</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}"
                                                                {{ $item->mark_lens == $category->id ? 'selected' : '' }}>
                                                                {{ $category->category_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>


                                                <div class="col-md-6">
                                                    <label for="lens_attribute">Lens Attribute</label><br>
                                                    <select name="lens_attribute" id="lens_attribute"
                                                        class="select2 form-control">
                                                        <option value="">Select Attribute</option>
                                                        <option value="1"
                                                            {{ $item->lens_attribute == 1 ? 'selected' : '' }}>
                                                            White </option>

                                                        <option value="2"
                                                            {{ $item->lens_attribute == 2 ? 'selected' : '' }}>
                                                            PhotoChromic </option>
                                                        <option value="3"
                                                            {{ $item->lens_attribute == 3 ? 'selected' : '' }}>
                                                            White BlueCat </option>
                                                        <option value="4"
                                                            {{ $item->lens_attribute == 4 ? 'selected' : '' }}>
                                                            PhotoChromic BlueCat </option>


                                                    </select>
                                                </div>

                                            </div><br>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="lens_power">Lens Power</label><br>
                                                    <select name="lens_power" id="lens_power" class="select2 form-control">
                                                        <option value="">Select Lens Power</option>
                                                        <option value="0"
                                                            {{ $item->lens_power == '0' ? 'selected' : '' }}>Plano</option>
                                                        <option value="0"
                                                            {{ $item->lens_power == '-0.25' ? 'selected' : '' }}>-0.25
                                                        </option>
                                                        <option value="-0.25"
                                                            {{ $item->lens_power == '0.25' ? 'selected' : '' }}>-0.25
                                                        </option>
                                                        <option value="0.25"
                                                            {{ $item->lens_power == '-0.22' ? 'selected' : '' }}>-0.22
                                                        </option>
                                                        <option value="0.15"
                                                            {{ $item->lens_power == '0.15' ? 'selected' : '' }}>0.15
                                                        </option>

                                                    </select>
                                                </div>


                                                <div class="col-md-6">
                                                    <label for="price">Price</label><br>
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
