@extends('layouts.app')

@section('page-title')
    {{ __('Request Order') }}
@endsection

@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="pull-left page-title"><b>New Order</b></h4>
                        <ol class="breadcrumb pull-right">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li class="active">Orders</li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3" style="margin-bottom: 10px">
                        <div class="panel-heading" style="background-color: #3e4550;">
                            <div class="row" style="color: #ffffff;">
                                <div class="col-md-12">
                                    @php
                                        $products = \App\Models\Product::all();
                                    @endphp
                                    <select class="form-control select2" name="product" id="product">
                                        <option value="">Choose Product</option>
                                        @foreach ($products as $item)
                                            <option value="{{ $item->id }}">{{ $item->product_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <!-- <div class="col-sm-3">
                        <div class="panel-heading" style="background-color: #3e4550;">
                            <div class="row" style="color: #ffffff;">
                                <a href="{{ route('admin.pending.order.details') }}"
                                    style="text-decoration: none; color: #fff">
                                    <div class="col-md-12 text-center">
                                        <button type="button" class="btn btn-success">VIEW PENDING ORDERS</button>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div> -->
                    <div class="col-sm-6"></div>
                    <!-- <div class="col-sm-3">
                        <div class="panel-heading" style="background-color: #3e4550;">
                            <div class="row" style="color: #ffffff;">
                                <a href="{{ route('admin.all-draft.list') }}"
                                    style="text-decoration: none; color: #fff">
                                    <div class="col-md-12 text-center">
                                        <button type="button" class="btn btn-warning">VIEW DRAFT ORDERS</button>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div> -->
                    <div class="col-sm-3">
                        <h3 class="pull-right page-title"><b>NEW ORDER</b><i class="ion-ios7-cart-outline"></i></h3>
                    </div>


                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-success product-selection" id="1-field">
                            <form action="{{ route('admin.order.add-cart') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <input type="hidden" value="1" name="product_id">
                                    <br>
                                    <div class="col-md-12">
                                        @php

                                            $suppliers = \App\Models\Supplier::where('status', true)->get();
                                        @endphp

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Supplier</label>
                                                <select class="form-control select2" name="supplier_id">
                                                    <option value="">Choose Supplier</option>
                                                    @foreach ($suppliers as $data)
                                                        <option value="{{ $data->id }}">{{ $data->supplier_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            @php
                                                $items = \App\Models\Item::where('product_category', 1)->get();
                                            @endphp
                                            <div class="form-group">
                                                <label for="mark_glasses">Brand:</label>
                                                <select class="form-control select2 code_show_input" name="mark_glass_id">
                                                    <option value="">Choose Brand</option>
                                                    @foreach ($items as $item)
                                                        <option value="{{ $item->mark_glasses }}">
                                                            {{ $item?->category?->category_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label for=""> Code</label>
                                            <select class="form-group select2" name="code_id">
                                                @foreach ($items as $item)
                                                    <option value="">Choose Code</option>
                                                    <option value="{{ $item->code_id }}">
                                                        {{ $item?->code?->code_name }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="color_id">Color:</label>
                                                <select class="form-control select2" name="color_id">
                                                    @foreach ($items as $item)
                                                        <option value="">Choose Color</option>
                                                        <option value="{{ $item->color_id }}">
                                                            {{ $item?->color?->color_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="quantity">Quantity:</label>
                                                <input type="number" class="form-control" id="quantity" name="quantity"
                                                    min="1">

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="price_input">Price</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="purchase_price"
                                                        placeholder="Price">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <br>
                                        <center><button class="btn btn-primary" type="submit" id="add-to-cart">Add to
                                                List</button>
                                        </center>
                                        <br>
                                    </div>
                                </div>
                            </form>
                        </div>


                        <div class="panel panel-success product-selection" id="3-field">
                            <form action="{{ route('admin.order.add-cart') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <input type="hidden" value="3" name="product_id">
                                    <br>
                                    <div class="col-md-12">
                                        @php

                                            $suppliers = \App\Models\Supplier::where('status', true)->get();
                                        @endphp

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Supplier</label>
                                                <select class="form-control select2" name="supplier_id">
                                                    <option value="">Choose Supplier</option>
                                                    @foreach ($suppliers as $data)
                                                        <option value="{{ $data->id }}">{{ $data->supplier_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            @php
                                                $items = \App\Models\Item::where('product_category', 3)->get();
                                            @endphp
                                            <div class="form-group">
                                                <label for="mark_glasses">Brand:</label>
                                                <select class="form-control select2 code_show_input" name="mark_glass_id">
                                                    <option value="">Choose Brand</option>
                                                    @foreach ($items as $item)
                                                        <option value="{{ $item->mark_glasses }}">
                                                            {{ $item?->category?->category_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label for=""> Code</label>
                                            <select class="form-group select2" name="code_id">
                                                <option value="">Choose Code</option>
                                                @foreach ($items as $item)
                                                    <option value="{{ $item->code_id }}">
                                                        {{ $item?->code?->code_name }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="color_id">Color:</label>
                                                <select class="form-control select2" name="color_id">

                                                    <option value="">Choose Color</option>
                                                    @foreach ($items as $item)
                                                        <option value="{{ $item->color_id }}">
                                                            {{ $item?->color?->color_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="quantity">Quantity:</label>
                                                <input type="number" class="form-control" id="quantity"
                                                    name="quantity" min="1">

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="price_input">Price</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="purchase_price"
                                                        placeholder="Price">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <br>
                                        <center><button class="btn btn-primary" type="submit" id="add-to-cart">Add to
                                                List</button>
                                        </center>
                                        <br>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="panel panel-success product-selection" id="4-field">
                            <form action="{{ route('admin.order.add-cart') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <input type="hidden" value="4" name="product_id">
                                    <br>
                                    <div class="col-md-12">
                                        @php

                                            $suppliers = \App\Models\Supplier::where('status', true)->get();
                                        @endphp

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Supplier</label>
                                                <select class="form-control select2" name="supplier_id">
                                                    <option value="">Choose Supplier</option>
                                                    @foreach ($suppliers as $data)
                                                        <option value="{{ $data->id }}">{{ $data->supplier_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            @php
                                                $items = \App\Models\Item::where('product_category', 4)->get();
                                            @endphp
                                            <div class="form-group">
                                                <label for="mark_glasses">Brand:</label>
                                                <select class="form-control select2 code_show_input" name="mark_glass_id">
                                                    <option value="">Choose Brand</option>
                                                    @foreach ($items as $item)
                                                        <option value="{{ $item->mark_glasses }}">
                                                            {{ $item?->category?->category_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label for=""> Code</label>
                                            <select class="form-group select2" name="code_id">
                                                <label for="code_id">Code:</label>
                                                @foreach ($items as $item)
                                                    <option value="{{ $item->code_id }}">
                                                        {{ $item?->code?->code_name }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="color_id">Color:</label>
                                                <select class="form-control select2" name="color_id">
                                                    @foreach ($items as $item)
                                                        <option value="">Choose Color</option>
                                                        <option value="{{ $item->color_id }}">
                                                            {{ $item?->color?->color_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="quantity">Quantity:</label>
                                                <input type="number" class="form-control" id="quantity"
                                                    name="quantity" min="1">

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="price_input">Price</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="purchase_price"
                                                        placeholder="Price">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <br>
                                        <center><button class="btn btn-primary" type="submit" id="add-to-cart">Add to
                                                List</button>
                                        </center>
                                        <br>
                                    </div>
                                </div>
                            </form>
                        </div>



                        <div class="panel panel-success product-selection" id="2-field">
                            <form action="{{ route('admin.order.lens.add-cart') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <input type="hidden" value="2" name="product_id">
                                    <br>
                                    <div class="col-md-12">
                                        @php
                                            $suppliers = \App\Models\Supplier::where('status', true)->get();
                                        @endphp

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Supplier</label>
                                                <select class="form-control select2 supplier" name="supplier_id">
                                                    <option value="">Choose Supplier</option>
                                                    @foreach ($suppliers as $data)
                                                        <option value="{{ $data->id }}">{{ $data->supplier_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">

                                                @php
                                                    $lens = \App\Models\Lens::get();
                                                @endphp
                                                <label for="mark_glasses">Category:</label>
                                                <select class="form-control select2 code_show_input" name="category_id">
                                                    <option value="">Choose Cetegory</option>
                                                    @foreach ($lens as $item)
                                                        <option value="{{ $item?->mark_lens }}">
                                                            {{ $item->category?->category_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="code_id">Attribute:</label>
                                                <select class="form-control select2" name="attribute_id"
                                                    id="attribute_id">
                                                    <option value="">Choose Attribute</option>
                                                    @foreach ($lens as $data)
                                                        <option value="{{ $data?->lens_attribute }}">
                                                            {{ $data->attribute?->attribute_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="color_id">Power:</label>
                                                <select class="form-control select2" id="power_id" name="power_id">
                                                    <option value="">Choose Power</option>
                                                    @foreach ($lens as $data)
                                                        <option value="{{ $data->lens_power }}">
                                                            {{ $data?->power?->sph }} - {{ $data?->power?->syl }} - {{ $data?->power?->axis }} - {{ $data?->power?->add_ }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">

                                                <label for="quantity">Quantity:</label>
                                                <input type="number" class="form-control" name="quantity"
                                                    min="1" max="">
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">

                                                <label for="quantity">Price:</label>
                                                <input type="text" class="form-control" name="purchase_price"
                                                    min="1" max="">
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <br>
                                        <center><button class="btn btn-primary" type="submit" id="add-to-cart">Add to
                                                List</button></center>

                                        <br>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>



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
                                    <h3 class="panel-title" style="color: #ffffff;">ORDER LIST</h3>
                                </div>
                                <div class="panel-body">
                                    <table id="datatable-buttons" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>SUPPLIER</th>
                                                <th>PRODUCT</th>
                                                <th>ITEM</th>
                                                <th>QUANTITY</th>
                                                <th>Amount</th>
                                                <th>Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $totalAmount = 0;
                                            @endphp
                                            @foreach ($carts as $index => $item)
                                                <tr>
                                                    <td>
                                                        {{ $index + 1 }}
                                                    </td>
                                                    <td>
                                                        {{ $item?->supplier?->supplier_name }}
                                                    </td>
                                                    <td>
                                                        {{ $item->product?->product_name }}
                                                    </td>
                                                    @if ($item->product_id == 1 || $item->product_id == 3 || $item->product_id == 4)
                                                        <td>{{ $item->item->category->category_name }}</td>
                                                    @elseif($item->product_id == 2)
                                                        <td>{{ $item?->lens?->category?->category_name }}</td>
                                                    @endif

                                                    <td>{{ $item->quantity }}</td>
                                                    <td>{{ number_format($item->amount) }} RWF</td>
                                                    <td>
                                                        <button class="btn btn-danger waves-effect waves-light"
                                                            style="margin: 4px;" id="removeItem"><a
                                                                href="{{ route('admin.order-cart.remove', ['id' => $item->id]) }}"
                                                                onclick="event.preventDefault();
                                                                             if (confirm('Are you sure you want to remove this item on list?')) {
                                                                                 document.getElementById('delete-form-{{ $item->id }}').submit();
                                                                             }"
                                                                style="text-decoration: none"
                                                                class="t-decoration-none text-white">
                                                                Remove <i class="fa fa-minus"></i></a></button>
                                                        <form id="delete-form-{{ $item->id }}"
                                                            action="{{ route('admin.order-cart.remove', ['id' => $item->id]) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </td>
                                                </tr>
                                                @php
                                                    $order_number = $item->order_number;
                                                    $totalAmount += $item->amount;
                                                    $formattedAmount = number_format($totalAmount, 0, '.', ',');
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
                                        <h3 class="panel-title" style="color: #ffffff;">PROCEED ORDER</h3>
                                    </div>
                                    <div class="panel-body" style="background-color:#c2c8d1;">
                                        <div class="container">
                                            <div class="row">
                                                {{ count($carts) }} {{ count($carts) == 1 ? 'ITEM' : 'ITEMS' }}
                                            </div>
                                            <br />
                                            <div class="row">
                                                TOTAL AMOUNT: {{ $formattedAmount }} RWF
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <form
                                                        action="{{ route('admin.order.list.accept.all', ['id' => $order_number]) }}"
                                                        method="POST" style="display:inline">
                                                        @csrf
                                                        <div class="col-md-4">
                                                            <button type="submit" style="margin-top: 12px"
                                                                class="btn btn-success waves-effect waves-light">MAKE
                                                                ORDER</button>
                                                        </div>
                                                    </form>
                                                </div>

                                                <div class="col-md-6">
                                                    <form method="POST"
                                                        action="
                                                        {{ route('admin.order.list.draft.all') }}
                                                        ">
                                                        @csrf
                                                        <button type="submit" class="btn btn-warning"
                                                            style="margin-top: 12px">
                                                            SAVE AS DRAFT
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to enable/disable fields based on selection
            function updateFieldStatus(selectedField, targetField) {
                var selectedValue = selectedField.val();
                if (selectedValue) {
                    targetField.prop('disabled', false);
                } else {
                    targetField.prop('disabled', true);
                    // Clear the options if the field is disabled
                    targetField.empty().append('<option value="">Choose ' + targetField.attr('name') + '</option>');
                }
            }


            // Hide all product sections
            $('.product-selection').hide();

            // Show the default product section
            $('#1-field').show();

            $('#product').change(function() {
                var selectedProduct = $(this).val();

                // Hide all product sections
                $('.product-selection').hide();
                $('#message-show').hide();
                // Show the selected product section
                $('#' + selectedProduct + '-field').show();
            });

        });
    </script>
@endsection
