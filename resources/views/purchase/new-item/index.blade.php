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
                            <li> <a href="{{ route('admin.purchase.order.index') }}">Orders</a></li>
                            <li class="active">New</li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <!-- <h3 class="pull-right page-title"><b>REGISTER ITEM BY ORDER </b></h3> -->
                    </div>
                    <div class="col-sm-3" style="margin-bottom: 10px">
                    </div>
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6">
                        <h3 class="pull-right page-title"><b>NEW ORDER</b><i class="ion-ios7-cart-outline"></i></h3>
                    </div>


                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-success product-selection" id="1-field">
                            <form action="{{ route('admin.order.add-cart.new-item') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <input type="hidden" value="{{ $number }}" name="product">
                                    <br>
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="target_client">Target Client</label><br>
                                                <select name="target_client" id="target_client"
                                                    class="select2 form-control">
                                                    <option value="">Select Target
                                                        Clients</option>
                                                    <option value="Kids">Kids</option>
                                                    <option value="Adults">Adults</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-md-3">
                                            @php
                                                $itemData = \App\Models\Item::get(['mark_glasses'])->unique(
                                                    'mark_glasses',
                                                );
                                            @endphp
                                            <div class="form-group">
                                                <label for="mark_glass_id">Brand:</label>
                                                <select class="form-control select2" name="mark_glass_id"
                                                    id="mark_glass_id">
                                                    <option value="">Choose Brand</option>
                                                    @foreach ($itemData as $item)
                                                        <option value="{{ $item->mark_glasses }}">
                                                            {{ $item->category?->category_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="code_id">Code</label>
                                            <input type="text" class="form-control" name="code_id" id="code_id"
                                                placeholder="Code">
                                        </div>
                                        @php
                                            $colors = \App\Models\Color::select('id', 'color_name')->distinct()->get();
                                        @endphp
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="color_id">Color:</label>
                                                <select class="form-control select2" name="color_id" id="color_id">
                                                    <option value="">Choose Color</option>
                                                    @foreach ($colors as $color)
                                                        <option value="{{ $color->id }}">{{ $color->color_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="col-md-6">
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
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="quantity">Quantity:</label>
                                                <input type="number" class="form-control" id="quantity" name="quantity"
                                                    min="1" placeholder="Qty">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="price_input">Price</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="price"
                                                        placeholder="Price">
                                                </div>
                                            </div>
                                        </div>


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
@endsection
