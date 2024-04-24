@extends('layouts.app')

@section('page-title')
    {{ __('Single Purchase') }}
@endsection



@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">

                <!-- Page-Title -->


                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="pull-left page-title"><b> PURCHASE</b><i class="ion-ios7-cart-outline"></i></h3>
                        <ol class="breadcrumb pull-right">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route('admin.purchase.index') }}">Purchase</a></li>
                            <li class="active">Details</li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <!-- USER LIST -->
                    <div class="col-lg-4 hidden-print">
                        <div class="panel panel-inverse" style="height: 280px">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="panel-title" style="color: #fff;">CONFIRM PURCHASE</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div id="userResurts" class="inbox-widget nicescroll mx-box">
                                    <form
                                        action="{{ route('admin.purchase.lens.update', ['id' => $data[0]->purchase_code]) }}"
                                        method="POST">
                                        @csrf

                                        <div class="row">
                                            @php
                                                $supplier = \App\Models\Supplier::all();
                                            @endphp
                                            <div class="col-md-9">
                                                <label for="payment_method">SUPPLIER</label><br>
                                                <select name="supplier_id" id="target_client" class="select2 form-control">
                                                    <option value="">Select Supplier</option>
                                                    @foreach ($supplier as $person)
                                                        <option value="{{ $person->id }}">{{ $person->supplier_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-2" style="margin-top: 6px">
                                                <label for=""></label>
                                                <a href="{{ route('admin.suppliers.index') }}"
                                                    class="btn btn-primary waves-effect waves-light">New
                                                    <i class="fa fa-plus"></i></a>
                                            </div>
                                        </div><br>




                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="payment_method">PAYMENT METHOD </label><br>
                                                <select name="payment_method" id="target_client"
                                                    class="select2 form-control">
                                                    <option>Choose Payment</option>
                                                    <option value="Cash">Cash</option>
                                                    <option value="Check">Check</option>
                                                    <option value="Transfer">Transfer</option>
                                                    <option value="Bank Slip">Bank Slip</option>
                                                </select>
                                            </div>
                                        </div>
                                        <br>

                                        <button type="submit" class="btn btn-success waves-effect waves-light"
                                            id="purchase_item">PURCHASE <i class="ion-ios7-cart-outline"></i></button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                    <div class="col-md-8">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <table border="1" width="100%">
                                    <tr>
                                        <th colspan="7">
                                            <h4 class="text-center">PURCHASE INFORMATION</h4>
                                            <div class="clearfix">
                                                <div class="pull-left" style="margin: 10px">
                                                    <strong>{{ strtoupper(env('APP_NAME')) }}</strong><br>
                                                    <strong>Address: Kigali Rwanda</strong><br>
                                                    <strong>Mobile: {{ auth()->user()->phone }}</strong><br>
                                                    <strong>Email: {{ auth()->user()->email }}</strong><br>
                                                    <strong>Purchase Number:
                                                        {{ $data[0]->purchase_code }}</strong><br>
                                                </div>
                                                <div class="pull-right">
                                                    <img src="" alt="LOGO" height="100"
                                                        width="200" alt="LOGO">
                                                </div>
                                            </div>
                                        </th>

                                    <tr style="height:20px">
                                        <th colspan="7"></th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>CATEGORY</th>
                                        <th>ATTRIBUTE</th>
                                        <th>POWER</th>
                                        <th>QUANTITY</th>
                                        <th>PRICE</th>
                                        <th>ACTION</th>
                                    </tr>
                                    <tbody>
                                        @php
                                            $totalPrice = 0;
                                        @endphp
                                        @foreach ($data as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $item->item?->category?->category_name }}</td>
                                                <td>{{ $item->item?->lens_attribute }}</td>
                                                <td>{{ $item->item?->lens_power }}</td>
                                                <td>{{ $item->qty }}</td>
                                                <td>{{ $item->price }}</td>
                                                <td>
                                                    <button class="btn btn-danger waves-effect waves-light"
                                                        style="margin: 4px;" id="removeItem"><a
                                                            href="{{ route('admin.purchase.lens.delete', ['id' => $item->item_id]) }}"
                                                            onclick="event.preventDefault();
                                                                         if (confirm('Are you sure you want to remove this item on list?')) {
                                                                             document.getElementById('delete-form-{{ $item->item_id }}').submit();
                                                                         }"
                                                            style="text-decoration: none"
                                                            class="t-decoration-none text-white">
                                                            Remove <i class="fa fa-minus"></i></a></button>
                                                    <form id="delete-form-{{ $item->item_id }}"
                                                        action="{{ route('admin.purchase.lens.delete', ['id' => $item->item_id]) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                            </tr>
                                            @php
                                                $totalPrice += $item->qty * $item->price;
                                            @endphp
                                        @endforeach
                                    </tbody>

                                    <tr>
                                        <th colspan="5">
                                            Bank of Kigali XXXXX-XXXXXXXX-XX/RWF<br>
                                            Account Name: RWANDA EYE CLINIC<br>
                                            RWANDA EYE CLINIC
                                        </th>
                                        <th colspan="2">TOTAL PRICE: {{ $totalPrice }}</th>
                                    </tr>
                                </table>
                            </div>
                            <hr>
                            <div class="hidden-print">
                                <div class="pull-right">
                                    <a href="javascript:window.print()" class="btn btn-inverse waves-effect waves-light"><i
                                            class="fa fa-print"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- container -->
    </div>
@endsection
