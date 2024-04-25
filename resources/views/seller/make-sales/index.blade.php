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
                        <h4 class="pull-left page-title"><b>Sale Glasses</b></h4>
                        <ol class="breadcrumb pull-right">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li class="active">Items</li>
                        </ol>
                    </div>
                </div>
                <form action="{{ route('seller.add.to.cart') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <!-- <h4>Choose Item</h4> -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="mark_glasses">Grasses Brand:</label>
                                    <select class="form-control select2 code_show_input" name="mark_glass_id"
                                        id="mark_glasses">
                                        <option value="">Choose Brand</option>
                                        @foreach ($items as $item)
                                            <option value="{{ $item->mark_glasses }}">{{ $item->category?->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="code_id">Code:</label>
                                    <select class="form-control select2" name="code_id" id="code_mi_id">
                                        <option value="">Choose Code</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="color_id">Color:</label>
                                    <select class="form-control select2" id="color_id" name="color_id">
                                        <option value="">Choose Color</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="quantity">Quantity:</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity"
                                        min="1">

                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <br><br><center><button class="btn btn-primary" type="submit" id="add-to-cart">Add to Cart</button></center>
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
                                                $totalAmount = 0;
                                            @endphp
                                            @foreach ($carts as $index => $item)
                                                <tr>
                                                    <td>
                                                        {{ $index + 1 }}
                                                    </td>
                                                    <td>{{ $item->item?->category->category_name }}</td>
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
                                                <div class="col-md-6">
                                                    <form method="POST"
                                                        action="{{ route('seller.performa.update', [$carts[0]->sale_code]) }}">
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
                            $.each(data, function(key, value) {
                                $('#color_id').append('<option value="' + key + '">' +
                                    value + '</option>');
                            });
                            // Enable color_id after populating options
                            $('#color_id').prop('disabled', false);
                        }
                    });
                }
            });

            // Enable quantity field when color is selected
            $('#color_id').on('change', function() {
                updateFieldStatus($(this), $('#quantity'));
            });
        });
    </script>
@endsection
