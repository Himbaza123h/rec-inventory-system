@extends('layouts.app')
@section('page-title')
    {{ __('Items | Lens') }}
@endsection


@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="pull-left page-title"><b>LENSES</b></h4>
                        <ol class="breadcrumb pull-right">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li class="active">Lens</li>
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
                                            <h4 class="panel-title"> New Item</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="inbox-widget nicescroll mx-box">
                                        <form action="{{ route('admin.item.lens.store') }}" method="POST">
                                            @csrf


                                            @php
                                                $category = \App\Models\Category::where('product', 2)->get();
                                            @endphp
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="mark_lens">Category of Lens</label><br>
                                                    <select name="mark_lens" id="target_client"
                                                        class=" select2 form-control">
                                                        <option value="">Category of Lens
                                                        </option>
                                                        @foreach ($category as $item)
                                                            <option value="{{ $item->id }}">{{ $item->category_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @php
                                                    $types = \App\Models\Type::where('product_category', 2)
                                                        ->where('status', true)
                                                        ->get();
                                                @endphp
                                                <div class="col-md-6">
                                                    <label for="type_name">Type</label><br>
                                                    <select name="type_name" id="type_name" class="select2 form-control">
                                                        <option value="">Select Type</option>
                                                        @foreach ($types as $item)
                                                            <option value="{{ $item->id }}">{{ $item->type_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div><br>
                                            @php
                                                $attributes = \App\Models\Attribute::get();
                                            @endphp
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="lens_attribute">Lens Attribute</label><br>
                                                    <select name="lens_attribute" id="target_client"
                                                        class="select2 form-control">

                                                        <option value="">Select Attribute
                                                        </option>
                                                        @foreach ($attributes as $item)
                                                            <option value="{{ $item->id }}">{{ $item->attribute_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div><br>


                                            @php
                                                $power_sph = \App\Models\Power::where('category', 'sph')->get();
                                                $power_cyl = \App\Models\Power::where('category', 'cyl')->get();
                                                $power_axis = \App\Models\Power::where('category', 'axis')->get();
                                                $power_add = \App\Models\Power::where('category', 'add')->get();
                                            @endphp
                                            <div class="row">

                                                <label for="lens_power">LENS POWER</label><br>
                                                <div class="col-md-3">

                                                    {{-- In case of showing placeholder --}}
                                                    <select name="sph" class="select2 form-control">
                                                        <option value="">SPH
                                                        </option>
                                                        @foreach ($power_sph as $item)
                                                            <option value="{{ $item->power_value }}">
                                                                {{ $item->power_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    {{-- Endings --}}
                                                </div>
                                                <div class="col-md-3">
                                                    {{-- In case of showing placeholder --}}
                                                    <select name="syl" class="select2 form-control">
                                                        <option value="">CYL
                                                        </option>
                                                        @foreach ($power_cyl as $item)
                                                            <option value="{{ $item->power_value }}">
                                                                {{ $item->power_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    {{-- Endings --}}
                                                </div>
                                                <div class="col-md-3">
                                                    {{-- In case of showing placeholder --}}
                                                    <select name="axis" class="select2 form-control">
                                                        <option value="">AXIS
                                                        </option>
                                                        @foreach ($power_axis as $item)
                                                            <option value="{{ $item->power_value }}">
                                                                {{ $item->power_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    {{-- Endings --}}
                                                </div>
                                                <div class="col-md-3">
                                                    {{-- In case of showing placeholder --}}
                                                    <select name="add_" class="select2 form-control">
                                                        <option value="">ADD
                                                        </option>
                                                        @foreach ($power_add as $item)
                                                            <option value="{{ $item->power_value }}">
                                                                {{ $item->power_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    {{-- Endings --}}
                                                </div>

                                            </div><br>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="price">Price </label><br>
                                                    <input type="text" name="price" id="size" class="form-control"
                                                        placeholder="Price">
                                                </div>
                                            </div><br>
                                            <br>
                                            <button type="submit" class="btn btn-success">Add Item</button>
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
                                        <h3 class="panel-title">List of Items</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div id="listTable" class="inbox-widget nicescroll mx-box">
                                    <table width="100%" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th rowspan="2">N/O</th>
                                                <th rowspan="2">Lens Category</th>
                                                <th rowspan="2">Type</th>
                                                <th rowspan="2">Lens Attribute</th>
                                                <th colspan="4" class="text-center">Lens Power</th>
                                                <th rowspan="2">Price</th>
                                                <th rowspan="2">Action</th>
                                            </tr>
                                            <tr>
                                                <th>SPH</th>
                                                <th>CYL</th>
                                                <th>AXIS</th>
                                                <th>ADD</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $index => $item)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $item->category?->category_name }}</td>
                                                    <td>{{ $item?->type?->type_name }}</td>
                                                    <td>{{ $item?->attribute?->attribute_name }}</td>
                                                    {{-- Placeholders --}}
                                                    <td>{{ $item->power_sph }}</td>
                                                    <td>{{ $item->power_cyl }}</td>

                                                    <td>{{ $item->power_axis }}</td>
                                                    <td>{{ $item->power_add }}</td>
                                                    {{-- End of placeholders --}}
                                                    <td>{{ $item->price }}</td>
                                                    <td>
                                                        <span class="btn btn-primary rounded p-2">
                                                            <a href="{{ route('admin.item.lens.edit', [$item->id]) }}"
                                                                style="text-decoration: none"
                                                                class="t-decoration-none text-white">{{ __('edit') }}</a>
                                                        </span>

                                                        <span class="btn btn-danger rounded p-2 m-2">
                                                            <a href="{{ route('admin.item.lens.delete', ['id' => $item->id]) }}"
                                                                onclick="event.preventDefault();
                                                                         if (confirm('Are you sure you want to delete this item?')) {
                                                                             document.getElementById('delete-form-{{ $item->id }}').submit();
                                                                         }"
                                                                style="text-decoration: none"
                                                                class="text-white">{{ __('delete') }}</a>
                                                        </span>
                                                        <form id="delete-form-{{ $item->id }}"
                                                            action="{{ route('admin.item.lens.delete', ['id' => $item->id]) }}"
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
