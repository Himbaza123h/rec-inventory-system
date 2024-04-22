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
                            <li><a href="{{ route('admin.items.index') }}">Glasses</a></li>
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
                                        <form action="{{ route('admin.item.update', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            @php
                                                $category = \App\Models\Category::where('product', 'sunglasses')->get();
                                                $color = \App\Models\Color::all();
                                                $code = \App\Models\Code::all();

                                            @endphp
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="target_client">Target Client</label><br>
                                                    <select name="target_client" id="target_client"
                                                        class="select2 form-control">
                                                        <option value="">Select Target Clients</option>
                                                        <option value="Kids"
                                                            {{ $item->target_client === 'Kids' ? 'selected' : '' }}>Kids
                                                        </option>
                                                        <option value="Adults"
                                                            {{ $item->target_client === 'Adults' ? 'selected' : '' }}>Adults
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="mark_glasses">Mark of Glasses</label><br>
                                                    <select name="mark_glasses" id="mark_glasses"
                                                        class="select2 form-control">
                                                        <option value="">Select mark of glasses</option>
                                                        @foreach ($category as $categoryItem)
                                                            <option value="{{ $categoryItem->id }}"
                                                                {{ $item->mark_glasses == $categoryItem->id ? 'selected' : '' }}>
                                                                {{ $categoryItem->category_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="code">Code</label><br>
                                                    <select name="code_id" id="code_id" class="select2 form-control">
                                                        <option value="">Select Color</option>
                                                        @foreach ($code as $codeItem)
                                                            <option value="{{ $codeItem->id }}"
                                                                {{ $item->code_id == $codeItem->id ? 'selected' : '' }}>
                                                                {{ $codeItem->code_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="size">Lens Width</label><br>
                                                    <input type="text" name="lens_width" id="size"
                                                        class="form-control" placeholder="Lens Width"
                                                        value="{{ $item->lens_width }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="size">Bridge Width</label><br>
                                                    <input type="text" name="bridge_width" id="size"
                                                        class="form-control" placeholder="Bridge Width"
                                                        value="{{ $item->bridge_width }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="size">Temple Length</label><br>
                                                    <input type="text" name="temple_length" id="size"
                                                        class="form-control" placeholder="Temple Length"
                                                        value="{{ $item->temple_length }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="color">Color</label><br>
                                                    <select name="color_id" id="color_id" class="select2 form-control">
                                                        <option value="">Select Color</option>
                                                        @foreach ($color as $colorItem)
                                                            <option value="{{ $colorItem->id }}"
                                                                {{ $item->color_id == $colorItem->id ? 'selected' : '' }}>
                                                                {{ $colorItem->color_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                                <div class="col-md-6">
                                                    <label for="price">Price</label><br>
                                                    <input type="text" name="price" id="price" class="form-control"
                                                        placeholder="Price" value="{{ $item->price }}">
                                                </div>
                                            </div>
                                            <br>
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
