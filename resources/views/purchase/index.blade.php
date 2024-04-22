@extends('layouts.app')

@section('page-title')
    {{ __('Purchase') }}
@endsection
@php
    function generatePurchaseCode()
    {
        // Generate a random 6-digit number
        return mt_rand(100000, 999999);
    }
    $randomCode = 'PUC' . generatePurchaseCode();
    $randomCode1 = 'PUCLENS' . generatePurchaseCode();
@endphp
@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <ol class="breadcrumb pull-right">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li class="active">Purchase</li>
                        </ol>
                    </div>
                </div>
                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-4" style="margin-bottom: 10px">
                        <div class="panel-heading" style="background-color: #3e4550;">
                            <div class="row" style="color: #ffffff;">
                                <div class="col-md-12">
                                    PRODUCT
                                    <select class="select2 form-control" name="product" id="product">
                                        <option>Choose Product</option>
                                        <option value="sunglasses">SUN GLASSES</option>
                                        <option value="lens">LENS</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">

                    </div>
                    <div class="col-sm-4">
                        <h3 class="pull-right page-title"><b> PURCHASE</b><i class="ion-ios7-cart-outline"></i></h3>
                    </div>


                </div>

                <!-- ADD PURCHASE ITEMS IN STOCK -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-color panel-primary">

                            <div class="panel-heading">
                                <div class="row product-section" id="sunglasses-field" style="color: #ffffff;">
                                    @php
                                        $items = \App\Models\Item::all();
                                    @endphp
                                    @if (count($items) > 0)
                                        <form method="POST" action="{{ route('admin.purchase.store') }}">
                                            <input type="hidden" class="text-dark" name="purchaseCode"
                                                value="{{ $randomCode }}" readonly>
                                            @csrf
                                            <table id="datatable-buttons" class="table table-striped"
                                                style="color: #ffffff">
                                                <thead>
                                                    <tr>
                                                        <th class="col-md-1">
                                                            N/O
                                                        </th>
                                                        <th class="col-md-5">
                                                            ITEM DETAILS
                                                        </th>
                                                        <th class="col-md-3">
                                                            QUANTITY
                                                        </th>

                                                        <th class="col-md-3">
                                                            UNIT PRICE
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($items as $index => $item)
                                                        <tr>
                                                            <td class="col-md-1">{{ $index + 1 }}</td>
                                                            <td>{{ $item->category?->category_name }} |
                                                                {{ $item->code?->code_name }} |
                                                                {{ $item->lens_width }}-{{ $item->bridge_width }}-{{ $item->temple_length }}
                                                                | {{ $item->color?->color_name }}
                                                            </td>
                                                            <td><input type="text" name="Qty_{{ $item->id }}"
                                                                    class="form-control qty-input" placeholder="Qty"
                                                                    data-item-id="{{ $item->id }}"></td>
                                                            <td><input type="text" name="price_{{ $item->id }}"
                                                                    class="form-control" placeholder="Price"></td>
                                                            <td><input type="checkbox" name="selected[]"
                                                                    value="{{ $item->id }}" class="checkbox"></td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <button type="submit" class="btn btn-primary waves-effect waves-light">ADD
                                                <i class="fa fa-plus"></i></button>
                                        </form>
                                    @else
                                        <div class="alert alert-info">No items available to purchase.</div>
                                    @endif
                                </div>


                                <div class="row product-section" id="lens-field" style="color: #ffffff;">
                                    @php
                                        $lens = \App\Models\Lens::all();
                                    @endphp
                                    @if (count($lens) > 0)
                                        <form method="POST" action="{{ route('admin.purchase.lens.store') }}">
                                            <input type="hidden" class="text-dark" name="purchase2Code"
                                                value="{{ $randomCode1 }}" readonly>
                                            @csrf
                                            <table id="datatable-buttons" class="table table-striped"
                                                style="color: #ffffff">
                                                <thead>
                                                    <tr>
                                                        <th class="col-md-1">
                                                            N/O
                                                        </th>
                                                        <th class="col-md-5">
                                                            ITEM DETAILS
                                                        </th>
                                                        <th class="col-md-3">
                                                            QUANTITY
                                                        </th>

                                                        <th class="col-md-3">
                                                            UNIT PRICE
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($lens as $index => $item)
                                                        <tr>
                                                            <td class="col-md-1">{{ $index + 1 }}</td>
                                                            <td>{{ $item->category?->category_name }} |
                                                                | {{ $item->lens_attribute }}
                                                            </td>
                                                            <td><input type="text" name="Qty2_{{ $item->id }}"
                                                                    class="form-control qty-input" placeholder="Qty"
                                                                    data-item-id="{{ $item->id }}"></td>
                                                            <td><input type="text" name="price2_{{ $item->id }}"
                                                                    class="form-control" placeholder="Price"></td>
                                                            <td><input type="checkbox" name="selected2[]"
                                                                    value="{{ $item->id }}" class="checkbox"></td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <button type="submit" class="btn btn-primary waves-effect waves-light">ADD
                                                <i class="fa fa-plus"></i></button>
                                        </form>
                                    @else
                                        <div class="alert alert-info">No items available to add.</div>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="panel-body">

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div id="infoDiv"></div>
                                <div id="listTable"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row product-section" id="sunglasses-table" style="color: #ffffff;">
                <div class="col-md-12">
                    <div class="panel panel-success">
                        <div class="panel-heading" style="background-color:#3e4550;">
                            <h3 class="panel-title" style="color: #ffffff;">GLASSES TO PURCHASE</h3>
                        </div>
                        <div class="panel-body">
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>DATE</th>
                                        <th>PURCHASE CODE</th>
                                        <th>Amount</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->created_at->format('Y-m-d') }}</td>
                                            <td>{{ $item->purchase_code }}</td>
                                            <td>{{ $data_array_2[$item->purchase_code] }}</td>
                                            <td>
                                                <button type="button" class="btn btn-success rounded p-2">
                                                    <a href="{{ route('admin.purchase.edit', [$item->purchase_code]) }}"
                                                        style="text-decoration: none"
                                                        class="t-decoration-none text-white">{{ __('view') }}</a>
                                                </button>
                                                <button class="btn btn-danger waves-effect waves-light" id="removeItem"><a
                                                        href="{{ route('admin.purchase.delete', ['id' => $item->purchase_code]) }}"
                                                        onclick="event.preventDefault();
                                                                         if (confirm('Are you sure you want to remove this purchase?')) {
                                                                             document.getElementById('delete-form-{{ $item->purchase_code }}').submit();
                                                                         }"
                                                        style="text-decoration: none"
                                                        class="t-decoration-none text-white">
                                                        Remove <i class="fa fa-minus"></i></a></button>
                                                <form id="delete-form-{{ $item->purchase_code }}"
                                                    action="{{ route('admin.purchase.delete', ['id' => $item->purchase_code]) }}"
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

            <div class="alert alert-info" id="message-show" style="margin-left: 20px; margin-right: 20px;">
                <p>
                <h4 class="text-center" style="color: #000">SELECT PRODUCT TO PURCHASE</h4>
                </p>
            </div>




            <div class="row product-section" id="lens-table" style="color: #ffffff;">
                <div class="col-md-12">
                    <div class="panel panel-success">
                        <div class="panel-heading" style="background-color:#3e4550;">
                            <h3 class="panel-title" style="color: #ffffff;">LENS TO PURCHASE</h3>
                        </div>
                        <div class="panel-body">
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>DATE</th>
                                        <th>PURCHASE CODE</th>
                                        <th>Amount</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lens2 as $index => $data)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $data->created_at->format('Y-m-d') }}</td>
                                            <td>{{ $data->purchase_code }}</td>
                                            <td>{{ $data_array_1[$data->purchase_code] }}</td>
                                            <td>
                                                <button type="button" class="btn btn-success rounded p-2">
                                                    <a href="{{ route('admin.purchase.lens.edit', [$data->purchase_code]) }}"
                                                        style="text-decoration: none"
                                                        class="t-decoration-none text-white">{{ __('view') }}</a>
                                                </button>
                                                <button class="btn btn-danger waves-effect waves-light" id="removeItem"><a
                                                        href="{{ route('admin.purchase.lens.delete', ['id' => $data->purchase_code]) }}"
                                                        onclick="event.preventDefault();
                                                                         if (confirm('Are you sure you want to remove this purchase?')) {
                                                                             document.getElementById('delete-form-{{ $item->purchase_code }}').submit();
                                                                         }"
                                                        style="text-decoration: none"
                                                        class="t-decoration-none text-white">
                                                        Remove <i class="fa fa-minus"></i></a></button>
                                                <form id="delete-form-{{ $data->purchase_code }}"
                                                    action="{{ route('admin.purchase.lens.delete', ['id' => $data->purchase_code]) }}"
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
        </div> <!-- container -->
    </div> <!-- content -->
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.product-section').hide();
            $('.product-table').hide();

            $('#product').change(function() {
                var selectedProduct = $(this).val();
                // Hide all product sections and tables
                $('.product-section').hide();
                $('.product-table').hide();
                $('#message-show').hide();
                // Show the selected product section and table
                $('#' + selectedProduct + '-field').show();
                $('#' + selectedProduct + '-table').show();
            });
        });
    </script>


    {{-- new script --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get all quantity input fields
            const qtyInputs = document.querySelectorAll('.qty-input');

            // Add event listener to each input field
            qtyInputs.forEach(function(input) {
                input.addEventListener('input', function() {
                    // Get the corresponding checkbox
                    const itemId = input.getAttribute('data-item-id');
                    const checkbox = document.querySelector('input[value="' + itemId +
                        '"].checkbox');

                    // Check the checkbox if input value is not empty, otherwise uncheck it
                    if (input.value.trim() !== '') {
                        checkbox.checked = true;
                    } else {
                        checkbox.checked = false;
                    }
                });
            });
        });
    </script>
@endsection
