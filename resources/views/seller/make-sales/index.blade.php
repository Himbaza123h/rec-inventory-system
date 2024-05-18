@extends('layouts.app')

@section('page-title')
    {{ __('Glass Sales') }}
@endsection

@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="pull-left page-title"><b>Make Sales</b></h4>
                        <ol class="breadcrumb pull-right">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li class="active">Sales</li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4" style="margin-bottom: 10px">
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
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-success product-selection" id="1-field">
                            <form action="{{ route('seller.make.sale.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <input type="hidden" value="1" name="product_id">
                                    <br>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="mark_glasses">Brand:</label>
                                                <select class="form-control select2 code_show_input" name="mark_glass_id"
                                                    id="mark_glasses">
                                                    <option value="">Choose Brand</option>
                                                    @foreach ($items as $item)
                                                        <option value="{{ $item->mark_glasses }}">
                                                            {{ $item->category?->category_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="code_id">Code:</label>
                                                <select class="form-control select2" name="code_id" id="code_mi_id">
                                                    <option value="">Choose Code</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="color_id">Color:</label>
                                                <select class="form-control select2" id="color_id" name="color_id">
                                                    <option value="">Choose Color</option>
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
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="price_input"></label>
                                                &nbsp;
                                                <label for="price_input">Sale (Price)</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon" id="price_span"></span>
                                                    <input type="text" class="form-control" name="sale_price"
                                                        placeholder="Sale Price">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <center>
                                        <p>Insurance Payment Option(Leave them blank if it's private)</p>
                                    </center>

                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            @php
                                                $insurances = \App\Models\Insurance::all();
                                            @endphp
                                            <label for="mark_glasses">Insurance:</label>
                                            <select class="form-control select2" name="insurance" id="product">
                                                <option value="">Choose Insurance</option>
                                                @foreach ($insurances as $item)
                                                    <option value="{{ $item->id }}">{{ $item->insurance_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="col-md-3">

                                            <label for="mark_glasses">Insurance ID:</label>
                                            <input type="text" name="insurance_number" id=""
                                                class="form-control" placeholder="290172XXXXX727628">
                                        </div>


                                        <div class="col-md-3">

                                            <label for="insurances">Covered Amount:</label>
                                            <input type="text" name="covered_amount" id="" class="form-control"
                                                placeholder="..rwf amount">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <br>
                                        <center><button class="btn btn-primary" type="submit" id="add-to-cart">Add to
                                                Cart</button>
                                        </center>
                                        <br>
                                    </div>
                                </div>
                            </form>
                        </div>


                        <div class="panel panel-success product-selection" id="3-field">
                            <form action="{{ route('seller.make.sale.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <input type="hidden" value="3" name="product_id">
                                    <br>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="mark_glasses">Brand:</label>
                                                <select class="form-control select2 code_show_input" name="mark_glass_id"
                                                    id="mark_glasses1">
                                                    <option value="">Choose Brand</option>
                                                    @foreach ($items1 as $item)
                                                        <option value="{{ $item->mark_glasses }}">
                                                            {{ $item->category?->category_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="code_id">Code:</label>
                                                <select class="form-control select2" name="code_id" id="code_mi_id1">
                                                    <option value="">Choose Code</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="color_id">Color:</label>
                                                <select class="form-control select2" id="color_id1" name="color_id">
                                                    <option value="">Choose Color</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="quantity">Quantity:</label>
                                                <input type="number" class="form-control" id="quantity1"
                                                    name="quantity" min="1">

                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="price_input">Purchase |</label>
                                                &nbsp;
                                                <label for="price_input">Sale (Price)</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon" id="price_span1"></span>
                                                    <input type="text" class="form-control" name="sale_price"
                                                        placeholder="Sale Price">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <center>
                                        <p>Insurance Payment Option(Leave them blank if it's private)</p>
                                    </center>

                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            @php
                                                $insurances = \App\Models\Insurance::all();
                                            @endphp
                                            <label for="mark_glasses">Insurance:</label>
                                            <select class="form-control select2" name="insurance" id="product">
                                                <option value="">Choose Insurance</option>
                                                @foreach ($insurances as $item)
                                                    <option value="{{ $item->id }}">{{ $item->insurance_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="col-md-3">

                                            <label for="mark_glasses">Insurance ID:</label>
                                            <input type="text" name="insurance_number" id=""
                                                class="form-control" placeholder="290172XXXXX727628">
                                        </div>


                                        <div class="col-md-3">

                                            <label for="insurances">Covered Amount:</label>
                                            <input type="text" name="covered_amount" id=""
                                                class="form-control" placeholder="..rwf amount">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <br>
                                        <center><button class="btn btn-primary" type="submit" id="add-to-cart">Add to
                                                Cart</button>
                                        </center>
                                        <br>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="panel panel-success product-selection" id="4-field">
                            <form action="{{ route('seller.make.sale.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <input type="hidden" value="4" name="product_id">
                                    <br>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="mark_glasses">Brand:</label>
                                                <select class="form-control select2 code_show_input" name="mark_glass_id"
                                                    id="mark_glasses2">
                                                    <option value="">Choose Brand</option>
                                                    @foreach ($items2 as $item)
                                                        <option value="{{ $item->mark_glasses }}">
                                                            {{ $item->category?->category_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="code_id">Code:</label>
                                                <select class="form-control select2" name="code_id" id="code_mi_id2">
                                                    <option value="">Choose Code</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="color_id">Color:</label>
                                                <select class="form-control select2" id="color_id2" name="color_id">
                                                    <option value="">Choose Color</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="quantity">Quantity:</label>
                                                <input type="number" class="form-control" id="quantity2"
                                                    name="quantity" min="1">

                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="price_input">Purchase |</label>
                                                &nbsp;
                                                <label for="price_input">Sale (Price)</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon" id="price_span2"></span>
                                                    <input type="text" class="form-control" name="sale_price"
                                                        placeholder="Sale Price">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <center>
                                        <p>Insurance Payment Option(Leave them blank if it's private)</p>
                                    </center>

                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            @php
                                                $insurances = \App\Models\Insurance::all();
                                            @endphp
                                            <label for="mark_glasses">Insurance:</label>
                                            <select class="form-control select2" name="insurance" id="product">
                                                <option value="">Choose Insurance</option>
                                                @foreach ($insurances as $item)
                                                    <option value="{{ $item->id }}">{{ $item->insurance_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="col-md-3">

                                            <label for="mark_glasses">Insurance ID:</label>
                                            <input type="text" name="insurance_number" id=""
                                                class="form-control" placeholder="290172XXXXX727628">
                                        </div>


                                        <div class="col-md-3">

                                            <label for="insurances">Covered Amount:</label>
                                            <input type="text" name="covered_amount" id=""
                                                class="form-control" placeholder="..rwf amount">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <br>
                                        <center><button class="btn btn-primary" type="submit" id="add-to-cart">Add to
                                                Cart</button>
                                        </center>
                                        <br>
                                    </div>
                                </div>
                            </form>
                        </div>



                        <div class="panel panel-success product-selection" id="2-field">
                            <form action="{{ route('seller.make.sale.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <input type="hidden" value="2" name="product_id">
                                    <br>
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="mark_glasses">Category:</label>
                                                <select class="form-control select2 code_show_input" name="category_id">
                                                    <option value="">Choose Cetegory</option>
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
                                                <select class="form-control select2" name="attribute_id"
                                                    id="attribute_id">
                                                    <option value="">Choose Attribute</option>
                                                    @foreach ($lens as $data)
                                                        <option value="{{ $data->item?->lens_attribute }}">
                                                            {{ $data->item?->attribute?->attribute_name }}</option>
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
                                                        <option value="{{ $data->item?->lens_power }}">
                                                            {{ $data->item?->power?->sph }} - {{ $data->item?->power?->syl }} - {{ $data->item?->power?->axis }} - {{ $data->item?->power?->add_ }}
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

                                                <label for="quantity">Sale Price:</label>
                                                <input type="text" class="form-control" name="sale_price"
                                                    min="1" max="">
                                            </div>
                                        </div>

                                    </div>
                                    <center>
                                        <p>Insurance Payment Option(Leave them blank if it's private)</p>
                                    </center>

                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            @php
                                                $insurances = \App\Models\Insurance::all();
                                            @endphp
                                            <label for="insurances">Insurance:</label>
                                            <select class="form-control select2" name="insurance" id="product">
                                                <option value="">Choose Insurance</option>
                                                @foreach ($insurances as $item)
                                                    <option value="{{ $item->id }}">{{ $item->insurance_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="col-md-3">

                                            <label for="mark_glasses">Insurance ID:</label>
                                            <input type="text" name="insurance_number" id=""
                                                class="form-control" placeholder="290172XXXXX727628">
                                        </div>


                                        <div class="col-md-3">

                                            <label for="mark_glasses">Covered Amount:</label>
                                            <input type="text" name="covered_amount" id=""
                                                class="form-control" placeholder="..rwf amount">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <br>
                                        <center><button class="btn btn-primary" type="submit" id="add-to-cart">Add to
                                                Cart</button></center>

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
                                                $totalAmount = 0;
                                            @endphp
                                            @foreach ($carts as $index => $item)
                                                <tr>
                                                    <td>
                                                        {{ $index + 1 }}
                                                    </td>
                                                    @if ($item->product_id == 1 || $item->product_id == 3 || $item->product_id == 4)
                                                        <td>{{ $item->item->category->category_name }}</td>
                                                    @elseif($item->product_id == 2)
                                                        <td>{{ $item->lens?->category?->category_name }}</td>
                                                    @endif

                                                    <td>{{ $item->qty }}</td>
                                                    <td>{{ $item->amount }}</td>
                                                    <td>
                                                        <span class="btn btn-danger rounded p-2 m-2">
                                                            <a href="{{ route('seller.item-cart.remove', ['id' => $item->item_id]) }}"
                                                                onclick="event.preventDefault();
                                                                     if (confirm('Are you sure you want to delete this on cart')) {
                                                                         document.getElementById('delete-form-{{ $item->item_id }}').submit();
                                                                     }"
                                                                style="text-decoration: none"
                                                                class="text-white">{{ __('delete') }}</a>
                                                        </span>
                                                        <form id="delete-form-{{ $item->item_id }}"
                                                            action="{{ route('seller.item-cart.remove', ['id' => $item->item_id]) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </td>
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
                                                        href="{{ route('seller.checkout', [$carts[0]->sale_code]) }}">
                                                        PROCEED CART
                                                    </a>
                                                </div>
                                                {{-- <div class="col-md-6">
                                                    <form method="POST"
                                                        action="{{ route('seller.performa.update', [$carts[0]->sale_code]) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-warning">
                                                            ADD TO PROFORMA
                                                        </button>
                                                    </form>
                                                </div> --}}
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


            // Initially disable all fields except mark_glasses
            $('#code_mi_id, #color_id, #quantity').prop('disabled', true);

            // Function to fetch codes based on selected mark_glass
            $('#mark_glasses').on('change', function() {
                updateFieldStatus($(this), $('#code_mi_id'));
                var markGlassId = $(this).val();
                if (markGlassId) {
                    $.ajax({
                        url: '{{ route('seller.fetch.codes') }}',
                        type: "GET",
                        data: {
                            mark_glass_id: markGlassId
                        },
                        dataType: "json",
                        success: function(data) {
                            $('#code_mi_id').empty().append(
                                '<option value="">Choose Code</option>');
                            $.each(data, function(key, value) {
                                $('#code_mi_id').append('<option value="' + key + '">' +
                                    value + '</option>');
                            });
                            // Enable code_mi_id after populating options
                            $('#code_mi_id').prop('disabled', false);
                        }
                    });
                }
            });

            // Function to fetch colors based on selected mark_glass and code
            $('#code_mi_id').on('change', function() {
                updateFieldStatus($(this), $('#color_id'));
                var markGlassId = $('#mark_glasses').val();
                var codeId = $(this).val();
                if (markGlassId && codeId) {
                    $.ajax({
                        url: '{{ route('seller.fetch.colors') }}',
                        type: "GET",
                        data: {
                            mark_glass_id: markGlassId,
                            code_id: codeId
                        },
                        dataType: "json",
                        success: function(data) {
                            $('#color_id').empty().append(
                                '<option value="">Choose Color</option>');
                            // $.each(data, function(key, value) {
                            //     $('#color_id').append('<option value="' + key + '">' +
                            //         value + '</option>');
                            // });
                            $.each(data, function(index, item) {
                                $('#color_id').append('<option value="' + item
                                    .color_id + '" data-price="' + item.price +
                                    '">' +
                                    item.color_name + '</option>');
                            });

                            // Enable color_id after populating options
                            $('#color_id').prop('disabled', false);
                        }
                    });
                }
            });

            $('#color_id').on('change', function() {
                updateFieldStatus($(this), $('#quantity'));
                // Get the selected option and its data-price attribute
                var selectedOption = $(this).find('option:selected');
                var price = selectedOption.data('price');
                // Display the price in the input field
                $('#price_input').val(price);
                $('#price_span').text(price);
            });









            // Section 2 selection fields


            $('#code_mi_id1, #color_id1, #quantity1').prop('disabled', true);

            // Function to fetch codes based on selected mark_glass
            $('#mark_glasses1').on('change', function() {
                updateFieldStatus($(this), $('#code_mi_id1'));
                var markGlassId1 = $(this).val();
                if (markGlassId1) {
                    $.ajax({
                        url: '{{ route('seller.fetch.codes') }}',
                        type: "GET",
                        data: {
                            mark_glass_id: markGlassId1
                        },
                        dataType: "json",
                        success: function(data) {
                            $('#code_mi_id1').empty().append(
                                '<option value="">Choose Code</option>');
                            $.each(data, function(key, value) {
                                $('#code_mi_id1').append('<option value="' + key +
                                    '">' +
                                    value + '</option>');
                            });
                            // Enable code_mi_id after populating options
                            $('#code_mi_id1').prop('disabled', false);
                        }
                    });
                }
            });

            // Function to fetch colors based on selected mark_glass and code
            $('#code_mi_id1').on('change', function() {
                updateFieldStatus($(this), $('#color_id1'));
                var markGlassId1 = $('#mark_glasses1').val();
                var codeId1 = $(this).val();
                if (markGlassId1 && codeId1) {
                    $.ajax({
                        url: '{{ route('seller.fetch.colors') }}',
                        type: "GET",
                        data: {
                            mark_glass_id: markGlassId1,
                            code_id: codeId1
                        },
                        dataType: "json",
                        success: function(data) {
                            $('#color_id1').empty().append(
                                '<option value="">Choose Color</option>');
                            // $.each(data, function(key, value) {
                            //     $('#color_id').append('<option value="' + key + '">' +
                            //         value + '</option>');
                            // });
                            $.each(data, function(index, item) {
                                $('#color_id1').append('<option value="' + item
                                    .color_id + '" data-price="' + item.price +
                                    '">' +
                                    item.color_name + '</option>');
                            });

                            // Enable color_id after populating options
                            $('#color_id1').prop('disabled', false);
                        }
                    });
                }
            });

            $('#color_id1').on('change', function() {
                updateFieldStatus($(this), $('#quantity1'));
                // Get the selected option and its data-price attribute
                var selectedOption = $(this).find('option:selected');
                var price = selectedOption.data('price');
                // Display the price in the input field
                $('#price_input1').val(price);
                $('#price_span1').text(price);
            });



            // Section 3 selection fields


            $('#code_mi_id2, #color_id2, #quantity2').prop('disabled', true);

            // Function to fetch codes based on selected mark_glass
            $('#mark_glasses2').on('change', function() {
                updateFieldStatus($(this), $('#code_mi_id2'));
                var markGlassId2 = $(this).val();
                if (markGlassId2) {
                    $.ajax({
                        url: '{{ route('seller.fetch.codes') }}',
                        type: "GET",
                        data: {
                            mark_glass_id: markGlassId2
                        },
                        dataType: "json",
                        success: function(data) {
                            $('#code_mi_id2').empty().append(
                                '<option value="">Choose Code</option>');
                            $.each(data, function(key, value) {
                                $('#code_mi_id2').append('<option value="' + key +
                                    '">' +
                                    value + '</option>');
                            });
                            // Enable code_mi_id after populating options
                            $('#code_mi_id2').prop('disabled', false);
                        }
                    });
                }
            });

            // Function to fetch colors based on selected mark_glass and code
            $('#code_mi_id2').on('change', function() {
                updateFieldStatus($(this), $('#color_id2'));
                var markGlassId2 = $('#mark_glasses2').val();
                var codeId2 = $(this).val();
                if (markGlassId2 && codeId2) {
                    $.ajax({
                        url: '{{ route('seller.fetch.colors') }}',
                        type: "GET",
                        data: {
                            mark_glass_id: markGlassId2,
                            code_id: codeId2
                        },
                        dataType: "json",
                        success: function(data) {
                            $('#color_id2').empty().append(
                                '<option value="">Choose Color</option>');
                            // $.each(data, function(key, value) {
                            //     $('#color_id').append('<option value="' + key + '">' +
                            //         value + '</option>');
                            // });
                            $.each(data, function(index, item) {
                                $('#color_id2').append('<option value="' + item
                                    .color_id + '" data-price="' + item.price +
                                    '">' +
                                    item.color_name + '</option>');
                            });

                            // Enable color_id after populating options
                            $('#color_id2').prop('disabled', false);
                        }
                    });
                }
            });

            $('#color_id2').on('change', function() {
                updateFieldStatus($(this), $('#quantity2'));
                // Get the selected option and its data-price attribute
                var selectedOption = $(this).find('option:selected');
                var price = selectedOption.data('price');
                // Display the price in the input field
                $('#price_input2').val(price);
                $('#price_span2').text(price);
            });



        });
    </script>
@endsection
