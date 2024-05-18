@extends('layouts.app')
@section('page-title')
    {{ __('Items | Glasses') }}
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
                            <li class="active">Items</li>
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
                                        <form action="{{ route('admin.item.store') }}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="hidden" name="product_type" value="4">
                                                    <label for="target_client">Target Client</label><br>
                                                    <select name="target_client" id="target_client"
                                                        class="select2 form-control">
                                                        <option value="">Select Target
                                                            Clients</option>
                                                        <option value="Kids">Kids</option>
                                                        <option value="Adults">Adults</option>
                                                    </select>
                                                </div>
                                            </div><br>

                                            @php
                                                $category = \App\Models\Category::where('product', 1)->get();
                                            @endphp

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="mark_glasses">Brand</label><br>
                                                    <select name="mark_glasses" id="mark_glasses"
                                                        class="select2 form-control">
                                                        <option value="">Select Brand</option>
                                                        @foreach ($category as $item)
                                                            <option value="{{ $item->id }}">{{ $item->category_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                {{-- @php
                                                    $code = \App\Models\Code::all();
                                                @endphp --}}
                                                <div class="col-md-6">
                                                    <label for="size">CODE</label><br>
                                                    <input type="text" name="code_id" id="code"
                                                        class="form-control" placeholder="ITEM CODE">
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="size">Size </label><br>
                                                    <input type="text" name="lens_width" id="size"
                                                        class="form-control" placeholder="Lens Width">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="size">&nbsp;</label><br>
                                                    <input type="text" name="bridge_width" id="size"
                                                        class="form-control" placeholder="Bridge Width">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="size">&nbsp;</label><br>
                                                    <input type="text" name="temple_length" id="size"
                                                        class="form-control" placeholder="Temple Length">
                                                </div>
                                            </div><br>
                                            @php
                                                $color = \App\Models\Color::all();
                                            @endphp
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="color">Color</label><br>
                                                    <select name="color_id" id="color" class="form-control select2"
                                                        placeholder="Color">
                                                        <option value="">Select color</option>
                                                        @foreach ($color as $item)
                                                            <option value="{{ $item->id }}">{{ $item->color_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="price">Price</label><br>
                                                    <input type="text" name="price" id="price" class="form-control"
                                                        placeholder="Price">
                                                </div>
                                            </div>
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
                                            <th>N/O</th>
                                            <th>Target Client</th>
                                            <th>Brand</th>
                                            <th>Code</th>
                                            <th>Size</th>
                                            <th>Color</th>
                                            <th>Price</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $index => $item)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $item->target_client }}</td>
                                                    <td>{{ $item->category?->category_name }}</td>
                                                    <td>{{ $item->code_id }}</td>
                                                    <td>{{ $item->lens_width }}-{{ $item->bridge_width }}-{{ $item->temple_length }}
                                                    </td>
                                                    <td>{{ $item->color?->color_name }}</td>
                                                    <td>{{ $item->price }}</td>
                                                    <td>
                                                        <span class="btn btn-primary rounded p-2">
                                                            <a href="{{ route('admin.item.edit', [$item->id]) }}"
                                                                style="text-decoration: none"
                                                                class="t-decoration-none text-white">{{ __('edit') }}</a>
                                                        </span>

                                                        <span class="btn btn-danger rounded p-2 m-2">
                                                            <a href="{{ route('admin.item.delete', ['id' => $item->id]) }}"
                                                                onclick="event.preventDefault();
                                                                         if (confirm('Are you sure you want to delete this item?')) {
                                                                             document.getElementById('delete-form-{{ $item->id }}').submit();
                                                                         }"
                                                                style="text-decoration: none"
                                                                class="text-white">{{ __('delete') }}</a>
                                                        </span>
                                                        <form id="delete-form-{{ $item->id }}"
                                                            action="{{ route('admin.item.delete', ['id' => $item->id]) }}"
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



    <script type="text/javascript" src="{{ asset('assets/plugins/jquery-multi-select/jquery.multi-select.js') }}"></script>
@endsection
