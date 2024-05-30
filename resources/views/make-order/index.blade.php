@extends('layouts.app')
@section('page-title')
    {{ __('Make Order') }}
@endsection

@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="pull-left page-title"><b>New Request Order</b></h4>
                        <ol class="breadcrumb pull-right">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li class="active">Orders</li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3"></div>
                    <br>
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6">
                        <h3 class="pull-right page-title"><b>REQUEST ORDER</b><i class="ion-ios7-cart-outline"></i></h3>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-success product-selection" id="2-field">
                            <br>
                            <form action="{{ route('seller.make.order.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">

                                        @php
                                            $itemData2 = \App\Models\Lens::get(['mark_lens'])->unique('mark_lens');
                                        @endphp
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="category_id">Category:</label>
                                                <select class="form-control select2 code_show_input" name="category_id"
                                                    id="category_id">
                                                    <option value="">Choose Category</option>
                                                    @foreach ($itemData2 as $item)
                                                        <option value="{{ $item->mark_lens }}">
                                                            {{ $item->category?->category_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        @php
                                            $types = \App\Models\Type::where('product_category', 2)->get();
                                        @endphp
                                        <div class="col-md-3">
                                            <label for="type_id">Type</label>
                                            <select class="form-control select2" name="type_id">
                                                <option value="">Choose Type</option>
                                                @foreach ($types as $item)
                                                    <option value="{{ $item->id }}">{{ $item->type_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="attribute_id">Attribute:</label>
                                                <select class="form-control select2" name="attribute_id" id="attribute_id"
                                                    disabled>
                                                    <option value="" disabled selected>Choose Attribute</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="color_id">SPH:</label>
                                                        <select class="form-control select2" id="power_sph"
                                                            name="power_sph">
                                                            <option value="">SPH</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="color_id">CYL:</label>
                                                        <select class="form-control select2" id="power_cyl"
                                                            name="power_cyl">
                                                            <option value="">CYL</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="color_id">AXIS:</label>
                                                        <select class="form-control select2" id="power_axis"
                                                            name="power_axis">
                                                            <option value="">AXIS</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="color_id">ADD:</label>
                                                        <select class="form-control select2" id="power_add"
                                                            name="power_add">
                                                            <option value="">ADD</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="quantity">Quantity:</label>
                                                <input type="number" class="form-control" name="quantity" min="1"
                                                    max="" placeholder="Qty">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="quantity">Price:</label>
                                                <input type="text" class="form-control" name="sale_price" min="1"
                                                    max="" placeholder="Price (rwf)">
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="insurance">Use Insurance</label><br>
                                                <input type="checkbox" id="insurance" style="width: 30px; height: 30px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" id="insurance-fields" style="display: none;">
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            @php
                                                $insurances = \App\Models\Insurance::where('status', true)->get();
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
                                                List</button></center>
                                        <br>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top:10vh;">
                    @if (count($orders) > 0)
                        <div class="col-md-8">
                        @else
                            <div class="col-md-12">
                    @endif
                    <div class="row product-section" style="color: #ffffff;">
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
                                                <th colspan="3">ITEM INFO</th>
                                                <th>SALE CODE</th>
                                                <th>QUANTITY</th>
                                                <th>Amount</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $totalAmount = 0;
                                            @endphp
                                            @foreach ($orders as $index => $item)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>
                                                        {{ $item?->item?->category?->category_name }}</td>
                                                    <td>
                                                        {{ $item?->item?->type?->type_name }}</td>

                                                    <td>
                                                        {{ $item?->item?->attribute?->attribute_name }}</td>
                                                    <td>{{ $item->order_code }}</td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>{{ number_format($item->amount, 0, '.', ',') }} RWF</td>
                                                    <td>
                                                        <form action="{{ route('seller.make.order.delete', $item->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Are you sure you want to delete this order?');">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>


                                                @php
                                                    $order_number = $item->order_code;
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

                @if (count($orders) > 0)
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-success" id="cart-items">
                                    <div class="panel-heading">
                                        <h3 class="panel-title" style="color: #000000;">LIST INFO</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <tbody>
                                                    @php
                                                        $cartTotal = 0;
                                                    @endphp
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>ORDER CODE</th>
                                                        <th>Total Amount</th>
                                                    </tr>
                                                    <tr>
                                                        <th>{{ $order_number }}</th>
                                                        <th>{{ $formattedAmount }} RWF</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <center><a
                                                href="{{ route('seller.make.order.proceed', ['id' => $order_number]) }}"
                                                class="btn btn-primary">PROCEED ORDER</a>

                                        </center>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endsection

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        {{-- Drop lenses hadling --}}
        <script>
            $(document).ready(function() {
                $('#category_id').change(function() {
                    var category_id = $(this).val();
                    if (category_id) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('get-attributes') }}",
                            data: {
                                _token: '{{ csrf_token() }}',
                                category_id: category_id
                            },
                            success: function(res) {
                                if (res && res.length > 0) {
                                    $("#attribute_id").empty().append(
                                        '<option value="" disabled selected>Choose Attribute</option>'
                                    );
                                    $.each(res, function(index, attribute) {
                                        $("#attribute_id").append('<option value="' +
                                            attribute.id + '">' + attribute
                                            .attribute_name + '</option>');
                                    });
                                    $("#attribute_id").append(
                                        '<option value="new_item">New Item</option>');
                                    $("#attribute_id").prop('disabled', false);
                                } else {
                                    $("#attribute_id").empty().prop('disabled', true);
                                }
                            }
                        });

                        $.ajax({
                            type: "POST",
                            url: "{{ route('get-type') }}",
                            data: {
                                _token: '{{ csrf_token() }}',
                                category_id: category_id
                            },
                            success: function(res) {
                                if (res && res.length > 0) {
                                    $("#type_id").empty().append(
                                        '<option value="" disabled selected>Choose Type</option>'
                                    );
                                    $.each(res, function(index, type) {
                                        $("#type_id").append('<option value="' +
                                            type.id + '">' + type.type_name +
                                            '</option>');
                                    });
                                    $("#type_id").prop('disabled', false);
                                } else {
                                    $("#type_id").empty().prop('disabled', true);
                                }
                            }
                        });
                    } else {
                        $("#attribute_id").empty().prop('disabled', true);
                        $("#type_id").empty().prop('disabled', true);
                    }
                });

                $('#attribute_id').change(function() {
                    var category_id = $('#category_id').val();
                    var attribute_id = $(this).val();

                    if (attribute_id === 'new_item') {
                        window.location.href = "";
                        return;
                    }

                    if (attribute_id) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('get-sph') }}",
                            data: {
                                _token: '{{ csrf_token() }}',
                                category_id: category_id,
                                attribute_id: attribute_id
                            },
                            success: function(res) {
                                if (res && res.length > 0) {
                                    $("#power_sph").empty().append(
                                        '<option value="" disabled selected>SPH</option>'
                                    );
                                    $.each(res, function(index, sph) {
                                        $("#power_sph").append('<option value="' + sph +
                                            '">' + sph + '</option>');
                                    });
                                    $("#power_sph").prop('disabled', false);
                                } else {
                                    $("#power_sph").empty().prop('disabled', true);
                                }
                            }
                        });

                        $.ajax({
                            type: "POST",
                            url: "{{ route('get-cyl') }}",
                            data: {
                                _token: '{{ csrf_token() }}',
                                category_id: category_id,
                                attribute_id: attribute_id
                            },
                            success: function(res) {
                                if (res && res.length > 0) {
                                    $("#power_cyl").empty().append(
                                        '<option value="" disabled selected>CYL</option>'
                                    );
                                    $.each(res, function(index, cyl) {
                                        $("#power_cyl").append('<option value="' + cyl +
                                            '">' + cyl + '</option>');
                                    });
                                    $("#power_cyl").prop('disabled', false);
                                } else {
                                    $("#power_cyl").empty().prop('disabled', true);
                                }
                            }
                        });

                        $.ajax({
                            type: "POST",
                            url: "{{ route('get-axis') }}",
                            data: {
                                _token: '{{ csrf_token() }}',
                                category_id: category_id,
                                attribute_id: attribute_id
                            },
                            success: function(res) {
                                if (res && res.length > 0) {
                                    $("#power_axis").empty().append(
                                        '<option value="" disabled selected>AXIS</option>'
                                    );
                                    $.each(res, function(index, axis) {
                                        $("#power_axis").append('<option value="' + axis +
                                            '">' + axis + '</option>');
                                    });
                                    $("#power_axis").prop('disabled', false);
                                } else {
                                    $("#power_axis").empty().prop('disabled', true);
                                }
                            }
                        });

                        $.ajax({
                            type: "POST",
                            url: "{{ route('get-add') }}",
                            data: {
                                _token: '{{ csrf_token() }}',
                                category_id: category_id,
                                attribute_id: attribute_id
                            },
                            success: function(res) {
                                if (res && res.length > 0) {
                                    $("#power_add").empty().append(
                                        '<option value="" disabled selected>ADD</option>'
                                    );
                                    $.each(res, function(index, add) {
                                        $("#power_add").append('<option value="' + add +
                                            '">' + add + '</option>');
                                    });
                                    $("#power_add").prop('disabled', false);
                                } else {
                                    $("#power_add").empty().prop('disabled', true);
                                }
                            }
                        });

                    } else {
                        $("#power_sph, #power_cyl, #power_axis, #power_add").empty().prop('disabled', true);
                    }
                });
            });
        </script>


        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const insuranceCheckbox = document.getElementById('insurance');
                const insuranceFields = document.getElementById('insurance-fields');

                insuranceCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        insuranceFields.style.display = 'block';
                    } else {
                        insuranceFields.style.display = 'none';
                    }
                });
            });
        </script>
