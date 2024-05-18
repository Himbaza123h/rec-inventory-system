@extends('layouts.app')
@section('page-title')
    {{ __('Lens Sales') }}
@endsection

@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="pull-left page-title"><b>Sale Lens</b></h4>
                        <ol class="breadcrumb pull-right">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li class="active">Items</li>
                        </ol>
                    </div>
                </div>
                <form action="{{ route('seller.cart.lens.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Choose Item</h4>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="mark_glasses">Category:</label>
                                    <select class="form-control select2 code_show_input" name="category_id"
                                        id="mark_glasses">
                                        <option value="">Choose Category</option>
                                        @php
                                            $lens = \App\Models\StockLens::get();
                                        @endphp
                                        @foreach ($lens as $item)
                                            <option value="{{ $item->item?->mark_lens }}">
                                                {{ $item->item?->category?->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="code_id">Attribute:</label>
                                    <select class="form-control select2" name="attribute_id" id="attribute_id">
                                        <option value="">Choose Attribute</option>
                                        @foreach ($lens as $data)
                                            <option value="{{ $data->item?->lens_attribute }}">
                                                {{ $data->item?->attribute?->attribute_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="color_id">Power:</label>
                                    <select class="form-control select2" id="power_id" name="power_id">
                                        <option value="">Choose Power</option>
                                        @foreach ($lens as $data)
                                            <option value="{{ $data->item?->lens_power }}">{{ $data->item?->lens_power }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">

                                    <label for="quantity">Quantity:</label>
                                    <input type="number" class="form-control" name="quantity" id="quantity" min="1"
                                        max="">
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <button class="btn btn-primary" type="submit" id="add-to-cart">Add to Cart</button>
                        </div>
                    </div>
                </form>
                <div class="row" style="margin-top:10vh;">
                    @if (count($carts) > 0)
                        <div class="col-md-8">
                        @else
                            <div class="col-md-12">
                    @endif
                    <div class="row product-section"style="color: #ffffff;">
                        <div class="col-md-12">
                            <div class="panel panel-success">
                                <div class="panel-heading" style="background-color:#3e4550;">
                                    <h3 class="panel-title" style="color: #ffffff;">CART LIST</h3>
                                </div>
                                <div class="panel-body">
                                    <table id="datatable-buttons" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>ITEM</th>
                                                <th>QUANTITY</th>
                                                <th>Amount</th>
                                                <th>Action</th>

                                            </tr>
                                        </thead>

                                        <tbody>
                                            @php
                                                $totalAmount = 0; // Initialize totalAmount variable
                                            @endphp
                                            @foreach ($carts as $index => $item)
                                                <tr>
                                                    <td>
                                                        {{ $index + 1 }}
                                                    </td>
                                                    <td>{{ $item->lens?->category->category_name }}</td>
                                                    <td>{{ $item->qty }}</td>
                                                    <td>{{ $item->amount }}</td>
                                                    <td>
                                                        <span class="btn btn-danger rounded p-2 m-2">
                                                            <a href="{{ route('seller.lens-cart.remove', ['id' => $item->item_id]) }}"
                                                                onclick="event.preventDefault();
                                                                     if (confirm('Are you sure you want to delete this on cart')) {
                                                                         document.getElementById('delete-form-{{ $item->item_id }}').submit();
                                                                     }"
                                                                style="text-decoration: none"
                                                                class="text-white">{{ __('delete') }}</a>
                                                        </span>
                                                        <form id="delete-form-{{ $item->item_id }}"
                                                            action="{{ route('seller.lens-cart.remove', ['id' => $item->item_id]) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </td>d>
                                                </tr>
                                                @php
                                                    $totalAmount += $item->amount;
                                                @endphp
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if (count($carts) > 0)
                    <div class="col-md-4">
                        <div class="row product-section"style="color: #ffffff;">
                            <div class="col-md-12">
                                <div class="panel panel-success">
                                    <div class="panel-heading" style="background-color:#3e4550;">
                                        <h3 class="panel-title" style="color: #ffffff;">PROCEED CART</h3>
                                    </div>
                                    <div class="panel-body" style="background-color:#c2c8d1;">
                                        <div class="container">
                                            <div class="row">
                                                TOTAL ITEMS: {{ count($carts) }}
                                            </div>
                                            <br />
                                            <div class="row">
                                                TOTAL AMOUNT: {{ $totalAmount }}
                                            </div><br>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <a class="btn btn-success"
                                                        href="{{ route('seller.lens.checkout', [$carts[0]->sale_lens_code]) }}">
                                                        PROCEED CART
                                                    </a>
                                                </div>
                                                <div class="col-md-6">
                                                    <form method="POST"
                                                        action="{{ route('seller.performa.lens.update', [$carts[0]->sale_lens_code]) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-warning">
                                                            ADD TO PERFORMA
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>


    </div>
    </div>
@endsection
