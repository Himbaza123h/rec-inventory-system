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
                                        <option value="" disabled>Choose Product</option>
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
                                                    <option value="" disabled selected>Choose Supplier</option>
                                                    @foreach ($suppliers as $data)
                                                        <option value="{{ $data->id }}">{{ $data->supplier_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            @php
                                                $itemData = \App\Models\Item::where('product_category', 1)
                                                    ->get(['mark_glasses'])
                                                    ->unique('mark_glasses');
                                            @endphp
                                            <div class="form-group">
                                                <label for="mark_glass_id">Brand:</label>
                                                <select class="form-control select2" name="mark_glass_id"
                                                    id="mark_glass_id">
                                                    <option value="">Choose Brand</option>
                                                    @foreach ($itemData as $item)
                                                        <option value="{{ $item->mark_glasses }}">
                                                            {{ $item->category->category_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="type_id">Type</label>
                                            <select class="form-control select2" name="type_id" id="type_id" disabled>
                                                <option value="" disabled selected>Choose Type</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="code_id">Code</label>
                                            <select class="form-control select2" name="code_id" id="code_id" disabled>
                                                <option value="" disabled selected>Choose Code</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="color_id">Color:</label>
                                                <select class="form-control select2" name="color_id" id="color_id"
                                                    disabled>
                                                    <option value="" disabled selected>Choose Color</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="size">Size:</label>
                                                <select class="form-control select2" name="size" id="size" disabled>
                                                    <option value="" disabled selected>Choose Size</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="quantity">Quantity:</label>
                                                <input type="number" class="form-control" id="quantity"
                                                    name="quantity" min="1" placeholder="Qty">
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
                                                List</button></center>
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
                                                    <option value="" disabled selected>Choose Supplier</option>
                                                    @foreach ($suppliers as $data)
                                                        <option value="{{ $data->id }}">{{ $data->supplier_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            @php
                                                $itemData = \App\Models\Item::where('product_category', 3)
                                                    ->get(['mark_glasses'])
                                                    ->unique('mark_glasses');
                                            @endphp
                                            <div class="form-group">
                                                <label for="mark_glass_id">Brand:</label>
                                                <select class="form-control select2" name="mark_glass_id"
                                                    id="mark_glass_id3">
                                                    <option value="">Choose Brand</option>
                                                    @foreach ($itemData as $item)
                                                        <option value="{{ $item->mark_glasses }}">
                                                            {{ $item->category->category_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="type_id">Type</label>
                                            <select class="form-control select2" name="type_id" id="type_id3" disabled>
                                                <option value="" disabled selected>Choose Type</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="code_id">Code</label>
                                            <select class="form-group select2" name="code_id" id="code_id3" disabled>
                                                <option value="" disabled selected>Choose Code</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="color_id">Color:</label>
                                                <select class="form-control select2" name="color_id" id="color_id3"
                                                    disabled>
                                                    <option value="" disabled selected>Choose Color</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="size">Size:</label>
                                                <select class="form-control select2" name="size" id="size3"
                                                    disabled>
                                                    <option value="" disabled selected>Choose Size</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="quantity">Quantity:</label>
                                                <input type="number" class="form-control" id="quantity"
                                                    name="quantity" min="1" placeholder="Qty">
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
                                                List</button></center>
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
                                                    <option value="" disabled selected>Choose Supplier</option>
                                                    @foreach ($suppliers as $data)
                                                        <option value="{{ $data->id }}">{{ $data->supplier_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            @php
                                                $itemData4 = \App\Models\Item::where('product_category', 4)
                                                    ->get(['mark_glasses'])
                                                    ->unique('mark_glasses');
                                            @endphp
                                            <div class="form-group">
                                                <label for="mark_glass_id">Brand:</label>
                                                <select class="form-control select2" name="mark_glass_id"
                                                    id="mark_glass_id4">
                                                    <option value="">Choose Brand</option>
                                                    @foreach ($itemData4 as $item)
                                                        <option value="{{ $item->mark_glasses }}">
                                                            {{ $item->category->category_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="type_id">Type</label>
                                            <select class="form-control select2" name="type_id" id="type_id4" disabled>
                                                <option value="" disabled selected>Choose Type</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="code_id">Code</label>
                                            <select class="form-group select2" name="code_id" id="code_id4" disabled>
                                                <option value="" disabled selected>Choose Code</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="color_id">Color:</label>
                                                <select class="form-control select2" name="color_id" id="color_id4"
                                                    disabled>
                                                    <option value="" disabled selected>Choose Color</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="size">Size:</label>
                                                <select class="form-control select2" name="size" id="size4"
                                                    disabled>
                                                    <option value="" disabled selected>Choose Size</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="quantity">Quantity:</label>
                                                <input type="number" class="form-control" id="quantity"
                                                    name="quantity" min="1" placeholder="Qty">
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
                                                List</button></center>
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
                                    <div class="col-md-12">
                                        @php
                                            $suppliers = \App\Models\Supplier::where('status', true)->get();
                                        @endphp

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Supplier</label>
                                                <select class="form-control select2 supplier" name="supplier_id">
                                                    <option value="" disabled selected>Choose Supplier</option>
                                                    @foreach ($suppliers as $data)
                                                        <option value="{{ $data->id }}">{{ $data->supplier_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        @php
                                            $itemData2 = \App\Models\Lens::get(['mark_lens'])->unique('mark_lens');
                                        @endphp
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="category_id">Category:</label>
                                                <select class="form-control select2 code_show_input" name="category_id"
                                                    id="category_id">
                                                    <option value="" disabled selected>Choose Category</option>
                                                    @foreach ($itemData2 as $item)
                                                        <option value="{{ $item->mark_lens }}">
                                                            {{ $item->category?->category_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        @php
                                            $types = \App\Models\Type::where('product_category', 2)
                                                ->where('status', true)
                                                ->get();
                                        @endphp
                                        <div class="col-md-2">
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
                                                <select class="form-control select2" name="attribute_id"
                                                    id="attribute_id" disabled>
                                                    <option value="" disabled selected>Choose Attribute</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
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

                                        <div class="col-md-2">
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

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="quantity">Quantity:</label>
                                                <input type="number" class="form-control" name="quantity"
                                                    min="1" max="" placeholder="Qty">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="quantity">Price:</label>
                                                <input type="text" class="form-control" name="purchase_price"
                                                    min="1" max="" placeholder="Price (rwf)">
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
                                                        <td>{{ $item->item?->category?->category_name }}</td>
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
                                                    <form action="{{ route('admin.order.list.accept.all') }}"
                                                        method="POST" style="display:inline">
                                                        @csrf
                                                        <div class="col-md-4">
                                                            <button type="submit" style="margin-top: 12px"
                                                                class="btn btn-success waves-effect waves-light">MAKE
                                                                ORDER</button>
                                                        </div>
                                                    </form>
                                                </div>

                                                {{-- <div class="col-md-6">
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
                    targetField.empty().append('<option value="" disabled>Choose ' + targetField.attr('name') +
                        '</option>');
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


    <script>
        $(document).ready(function() {
            $('#mark_glass_id').change(function() {
                resetFields();
                var brandId = $(this).val();
                if (brandId) {
                    enableTypeDropdown(brandId);
                }
            });

            $('#type_id').change(function() {
                var brandId = $('#mark_glass_id').val();
                var typeId = $('#type_id').val();
                if (brandId && typeId) {
                    enableCodeDropdown(brandId, typeId);
                }
            });

            $('#code_id').change(function() {
                var selectedOption = $(this).val();
                if (selectedOption === 'new-item') {
                    window.location.href = "{{ route('admin.requests-new-item') }}?number=1";
                    return;
                }
                var brandId = $('#mark_glass_id').val();
                var typeId = $('#type_id').val();
                var codeId = $(this).val();
                if (brandId && typeId && codeId) {
                    enableColorDropdown(brandId, typeId, codeId);
                }
            });

            $('#color_id').change(function() {
                var brandId = $('#mark_glass_id').val();
                var typeId = $('#type_id').val();
                var codeId = $('#code_id').val();
                var colorId = $(this).val();
                if (brandId && typeId && codeId && colorId) {
                    enableSizeDropdown(brandId, typeId, codeId, colorId);
                }
            });

            function resetFields() {
                $('#type_id').prop('disabled', true).empty().append(
                    '<option value="" disabled selected>Choose Type</option>');
                $('#code_id').prop('disabled', true).empty().append(
                    '<option value="" disabled selected>Choose Code</option>');
                $('#color_id').prop('disabled', true).empty().append(
                    '<option value="" disabled selected>Choose Color</option>');
                $('#size').prop('disabled', true).empty().append(
                    '<option value="" disabled selected>Choose Size</option>');
            }

            function enableTypeDropdown(brandId) {
                $.ajax({
                    url: "{{ route('get-types') }}",
                    type: "POST",
                    data: {
                        brand_id: brandId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('#type_id').prop('disabled', false).empty().append(
                            '<option value="" disabled selected>Choose Type</option>');
                        $.each(data, function(index, value) {
                            $('#type_id').append('<option value="' + value.id + '">' + value
                                .type_name + '</option>');
                        });
                    }
                });
            }

            function enableCodeDropdown(brandId, typeId) {
                $.ajax({
                    url: "{{ route('get-codes') }}",
                    type: "POST",
                    data: {
                        brand_id: brandId,
                        type_id: typeId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('#code_id').prop('disabled', false).empty().append(
                            '<option value="" disabled selected>Choose Code</option>');
                        $.each(data, function(index, value) {
                            $('#code_id').append('<option value="' + value + '">' + value +
                                '</option>');
                        });
                        $('#code_id').append('<option value="new-item">New Item</option>');
                    }
                });
            }

            function enableColorDropdown(brandId, typeId, codeId) {
                $.ajax({
                    url: "{{ route('get-colors') }}",
                    type: "POST",
                    data: {
                        brand_id: brandId,
                        type_id: typeId,
                        code_id: codeId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('#color_id').prop('disabled', false).empty().append(
                            '<option value="" disabled selected>Choose Color</option>');
                        $.each(data, function(index, value) {
                            $('#color_id').append('<option value="' + value.id + '">' + value
                                .color_name + '</option>');
                        });
                    }
                });
            }

            function enableSizeDropdown(brandId, typeId, codeId, colorId) {
                $.ajax({
                    url: "{{ route('get-sizes') }}",
                    type: "POST",
                    data: {
                        brand_id: brandId,
                        type_id: typeId,
                        code_id: codeId,
                        color_id: colorId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('#size').prop('disabled', false).empty().append(
                            '<option value="" disabled selected>Choose Size</option>');
                        $.each(data, function(index, value) {
                            $('#size').append('<option value="' + value + '">' + value +
                                '</option>');
                        });
                    }
                });
            }
        });
    </script>
    {{-- Handling sunglasses --}}

    <script>
        $(document).ready(function() {
            $('#mark_glass_id4').change(function() {
                resetFields();
                var brandId = $(this).val();
                if (brandId) {
                    enableTypeDropdown(brandId);
                }
            });

            $('#type_id4').change(function() {
                var brandId = $('#mark_glass_id4').val();
                var typeId = $('#type_id4').val();
                if (brandId && typeId) {
                    enableCodeDropdown(brandId, typeId);
                }
            });

            $('#code_id4').change(function() {
                var selectedOption = $(this).val();
                if (selectedOption === 'new-item') {
                    window.location.href = "{{ route('admin.requests-new-item') }}?number=3";
                    return;
                }
                var brandId = $('#mark_glass_id4').val();
                var typeId = $('#type_id4').val();
                var codeId = $(this).val();
                if (brandId && typeId && codeId) {
                    enableColorDropdown(brandId, typeId, codeId);
                }
            });

            $('#color_id4').change(function() {
                var brandId = $('#mark_glass_id4').val();
                var typeId = $('#type_id4').val();
                var codeId = $('#code_id4').val();
                var colorId = $(this).val();
                if (brandId && typeId && codeId && colorId) {
                    enableSizeDropdown(brandId, typeId, codeId, colorId);
                }
            });

            function resetFields() {
                $('#type_id4').prop('disabled', true).empty().append(
                    '<option value="" disabled selected>Choose Type</option>');
                $('#code_id4').prop('disabled', true).empty().append(
                    '<option value="" disabled selected>Choose Code</option>');
                $('#color_id4').prop('disabled', true).empty().append(
                    '<option value="" disabled selected>Choose Color</option>');
                $('#size4').prop('disabled', true).empty().append(
                    '<option value="" disabled selected>Choose Size</option>');
            }

            function enableTypeDropdown(brandId) {
                $.ajax({
                    url: "{{ route('get-types4') }}",
                    type: "POST",
                    data: {
                        brand_id: brandId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('#type_id4').prop('disabled', false).empty().append(
                            '<option value="" disabled selected>Choose Type</option>');
                        $.each(data, function(index, value) {
                            $('#type_id4').append('<option value="' + value.id + '">' + value
                                .type_name + '</option>');
                        });
                    }
                });
            }

            function enableCodeDropdown(brandId, typeId) {
                $.ajax({
                    url: "{{ route('get-codes4') }}",
                    type: "POST",
                    data: {
                        brand_id: brandId,
                        type_id: typeId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('#code_id4').prop('disabled', false).empty().append(
                            '<option value="" disabled selected>Choose Code</option>');
                        $.each(data, function(index, value) {
                            $('#code_id4').append('<option value="' + value + '">' + value +
                                '</option>');
                        });
                        $('#code_id4').append('<option value="new-item">New Item</option>');
                    }
                });
            }

            function enableColorDropdown(brandId, typeId, codeId) {
                $.ajax({
                    url: "{{ route('get-colors4') }}",
                    type: "POST",
                    data: {
                        brand_id: brandId,
                        type_id: typeId,
                        code_id: codeId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('#color_id4').prop('disabled', false).empty().append(
                            '<option value="" disabled selected>Choose Color</option>');
                        $.each(data, function(index, value) {
                            $('#color_id4').append('<option value="' + value.id + '">' + value
                                .color_name + '</option>');
                        });
                    }
                });
            }

            function enableSizeDropdown(brandId, typeId, codeId, colorId) {
                $.ajax({
                    url: "{{ route('get-sizes4') }}",
                    type: "POST",
                    data: {
                        brand_id: brandId,
                        type_id: typeId,
                        code_id: codeId,
                        color_id: colorId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('#size4').prop('disabled', false).empty().append(
                            '<option value="" disabled selected>Choose Size</option>');
                        $.each(data, function(index, value) {
                            $('#size4').append('<option value="' + value + '">' + value +
                                '</option>');
                        });
                    }
                });
            }
        });
    </script>





    {{-- Handling Reading glasses --}}

    <script>
        $(document).ready(function() {
            $('#mark_glass_id3').change(function() {
                resetFields();
                var brandId = $(this).val();
                if (brandId) {
                    enableTypeDropdown(brandId);
                }
            });

            $('#type_id3').change(function() {
                var brandId = $('#mark_glass_id3').val();
                var typeId = $('#type_id3').val();
                if (brandId && typeId) {
                    enableCodeDropdown(brandId, typeId);
                }
            });

            $('#code_id3').change(function() {
                var selectedOption = $(this).val();
                if (selectedOption === 'new-item') {
                    window.location.href = "{{ route('admin.requests-new-item') }}?number=3";
                    return;
                }
                var brandId = $('#mark_glass_id3').val();
                var typeId = $('#type_id3').val();
                var codeId = $(this).val();
                if (brandId && typeId && codeId) {
                    enableColorDropdown(brandId, typeId, codeId);
                }
            });

            $('#color_id3').change(function() {
                var brandId = $('#mark_glass_id3').val();
                var typeId = $('#type_id3').val();
                var codeId = $('#code_id3').val();
                var colorId = $(this).val();
                if (brandId && typeId && codeId && colorId) {
                    enableSizeDropdown(brandId, typeId, codeId, colorId);
                }
            });

            function resetFields() {
                $('#type_id3').prop('disabled', true).empty().append(
                    '<option value="" disabled selected>Choose Type</option>');
                $('#code_id3').prop('disabled', true).empty().append(
                    '<option value="" disabled selected>Choose Code</option>');
                $('#color_id3').prop('disabled', true).empty().append(
                    '<option value="" disabled selected>Choose Color</option>');
                $('#size3').prop('disabled', true).empty().append(
                    '<option value="" disabled selected>Choose Size</option>');
            }

            function enableTypeDropdown(brandId) {
                $.ajax({
                    url: "{{ route('get-types3') }}",
                    type: "POST",
                    data: {
                        brand_id: brandId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('#type_id3').prop('disabled', false).empty().append(
                            '<option value="" disabled selected>Choose Type</option>');
                        $.each(data, function(index, value) {
                            $('#type_id3').append('<option value="' + value.id + '">' + value
                                .type_name + '</option>');
                        });
                    }
                });
            }

            function enableCodeDropdown(brandId, typeId) {
                $.ajax({
                    url: "{{ route('get-codes3') }}",
                    type: "POST",
                    data: {
                        brand_id: brandId,
                        type_id: typeId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('#code_id3').prop('disabled', false).empty().append(
                            '<option value="" disabled selected>Choose Code</option>');
                        $.each(data, function(index, value) {
                            $('#code_id3').append('<option value="' + value + '">' + value +
                                '</option>');
                        });
                        $('#code_id3').append('<option value="new-item">New Item</option>');
                    }
                });
            }

            function enableColorDropdown(brandId, typeId, codeId) {
                $.ajax({
                    url: "{{ route('get-colors3') }}",
                    type: "POST",
                    data: {
                        brand_id: brandId,
                        type_id: typeId,
                        code_id: codeId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('#color_id3').prop('disabled', false).empty().append(
                            '<option value="" disabled selected>Choose Color</option>');
                        $.each(data, function(index, value) {
                            $('#color_id3').append('<option value="' + value.id + '">' + value
                                .color_name + '</option>');
                        });
                    }
                });
            }

            function enableSizeDropdown(brandId, typeId, codeId, colorId) {
                $.ajax({
                    url: "{{ route('get-sizes3') }}",
                    type: "POST",
                    data: {
                        brand_id: brandId,
                        type_id: typeId,
                        code_id: codeId,
                        color_id: colorId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('#size3').prop('disabled', false).empty().append(
                            '<option value="" disabled selected>Choose Size</option>');
                        $.each(data, function(index, value) {
                            $('#size3').append('<option value="' + value + '">' + value +
                                '</option>');
                        });
                    }
                });
            }
        });
    </script>


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

@endsection
