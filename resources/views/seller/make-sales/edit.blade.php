@extends('layouts.app')

@section('page-title')
    {{ __('Confirm Checkout') }}
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
                        <div class="panel panel-inverse" style="height: 300px">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="panel-title" style="color: #fff;">CONFIRM CHECKOUT</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div id="userResurts" class="inbox-widget nicescroll mx-box">
                                    <form action="{{ route('seller.checkout.update', ['id' => $data[0]->sale_code]) }}"
                                        method="POST">
                                        @csrf
                                        <input type="hidden" name="_method" value="PUT">
                                        <div class="row">
                                            @php
                                                $customer = \App\Models\Customer::all();
                                            @endphp
                                            <div class="col-md-9">
                                                <label for="payment_method">CUSTOMER</label><br>
                                                <select name="buyer_id" id="target_client" class="select2 form-control">
                                                    <option value="">Select Customer</option>
                                                    @foreach ($customer as $person)
                                                        <option value="{{ $person->id }}">{{ $person->customer_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-2" style="margin-top: 6px">
                                                <label for=""></label>
                                                <a href="{{ route('seller.customers.index') }}"
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
                                        </div><br>
                                        <br>
                                        <button type="submit" class="btn btn-success waves-effect waves-light"
                                            id="purchase_item">CONFIRM <i class="ion-ios7-cart-outline"></i></button>
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
                                        <th colspan="8">
                                            <h4 class="text-center">SALE INFORMATION</h4>
                                            <div class="clearfix">
                                                <div class="pull-left" style="margin: 10px">
                                                    <strong>{{ strtoupper(env('APP_NAME')) }}</strong><br>
                                                    <strong>Address: Kigali Rwanda</strong><br>
                                                    <strong>Mobile: {{ auth()->user()->phone }}</strong><br>
                                                    <strong>Email: {{ auth()->user()->email }}</strong><br>
                                                    <strong>Purchase Number:
                                                        {{ $data[0]->sale_code }}</strong><br>
                                                </div>
                                                <div class="pull-right">
                                                    <img src="{{ asset('assets/images/electric.jpg') }}" height="100"
                                                        width="200" alt="LOGO">
                                                </div>
                                            </div>
                                        </th>

                                    <tr style="height:20px">
                                        <th colspan="8"></th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>ITEM BRAND</th>
                                        <th>CODE</th>
                                        <th>SIZE</th>
                                        <th>COLOR</th>
                                        <th>QUANTITY</th>
                                        <th>PRICE</th>
                                    </tr>
                                    <tbody>
                                        @php
                                            $totalPrice = 0;
                                        @endphp
                                        @foreach ($data as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $item->item?->category?->category_name }}</td>
                                                <td>{{ $item->item?->code?->code_name }}</td>
                                                <td>{{ $item->item?->lens_width }}-{{ $item->item?->bridge_width }}-{{ $item->item?->temple_length }}
                                                </td>
                                                <td>{{ $item->item?->color?->color_name }}</td>
                                                <td>{{ $item->qty }}</td>
                                                <td>{{ $item->price }}</td>
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
                                        <th colspan="2">TOTOL PRICE: {{ $totalPrice }}</th>
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
