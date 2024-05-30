@extends('layouts.app')

@section('page-title')
    {{ __('Add to Pending') }}
@endsection



@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">

                <!-- Page-Title -->


                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="pull-left page-title"><b> SALE</b><i class="ion-ios7-cart-outline"></i></h3>
                        <ol class="breadcrumb pull-right">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route('seller.make.sales.index') }}">Sales</a></li>
                            <li class="active">Pendings</li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <!-- USER LIST -->
                    <div class="col-lg-4 hidden-print">
                        <div class="panel panel-inverse" style="height: 360px">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="panel-title" style="color: #fff;">ADD TO PENDING</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div id="userResurts" class="inbox-widget nicescroll mx-box">
                                    <form action="{{ route('seller.checkout.pending', ['id' => $data[0]->sale_code]) }}"
                                        method="POST">
                                        @csrf
                                        <input type="hidden" name="_method" value="PUT">

                                        <div class="row">
                                            <div class="col-md-12">
                                                @php
                                                    $operators = \App\Models\Seller::where('status', true)->get();
                                                @endphp
                                                <label for="payment_method">OPERATOR </label><br>
                                                <select name="operator_id" id="seller" class="select2 form-control">
                                                    <option>Choose Operator</option>
                                                    @foreach ($operators as $item)
                                                        <option value="{{ $item->id }}">{{ $item->seller_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div><br>
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
                                        <button type="submit" class="btn btn-success waves-effect waves-light"
                                            id="purchase_item">SEND<i class="ion-ios7-cart-outline"></i></button>
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
                                                    <strong>Sale Number:
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
                                        <th colspan="3" class="text-center">ITEM INFO</th>
                                        <th>QUANTITY</th>
                                        <th>PRICE</th>
                                    </tr>
                                    <tbody>
                                        @php
                                            $totalPrice = 0;
                                            $covered = 0;
                                        @endphp
                                        @foreach ($data as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                @if ($item->product_id == 1 || $item->product_id == 3 || $item->product_id == 4)
                                                    <td>{{ $item->item?->category?->category_name }}</td>
                                                    <td>{{ $item->item?->code_id }}</td>
                                                    <td>{{ $item->item?->lens_width }}-{{ $item->item?->bridge_width }}-{{ $item->item?->temple_length }}
                                                    </td>
                                                @elseif($item->product_id == 2)
                                                    <td>{{ $item->lens->category->category_name }}</td>
                                                    <td>{{ $item->lens->attribute?->attribute_name }}</td>
                                                    <td>{{ $item->lens?->power_sph }}-{{ $item->lens?->power_cyl }}-{{ $item->lens?->power_axis }}-{{ $item->lens?->power_add }}
                                                    </td>
                                                @endif
                                                <td>{{ $item->qty }}</td>
                                                <td>{{ $item->price }}</td>
                                                <td class="covered" style="display: none;">{{ $item->covered }}</td>
                                            </tr>
                                            @php
                                                $totalPrice += $item->qty * $item->price;
                                                $covered += $item->covered;
                                                $formattedTotalPrice = number_format($totalPrice) . 'RWF';
                                                $formattedCovered = number_format($covered) . 'RWF';

                                                $toUup = $totalPrice - $covered;
                                                $topUpAmount = number_format($toUup) . 'RWF';

                                            @endphp
                                        @endforeach

                                    </tbody>

                                    <tr>
                                        <th colspan="5">
                                            Bank of Kigali XXXXX-XXXXXXXX-XX/RWF<br>
                                            Account Name: RWANDA EYE CLINIC<br>
                                            RWANDA EYE CLINIC
                                        </th>
                                        <th colspan="2">
                                            <div class="" style="margin-left: 10px">
                                                INSURANCE : {{ $formattedCovered }} <br><br>
                                                TOTOL AMOUNT: {{ $formattedTotalPrice }}<br>
                                                 TOP UP AMOUNT: {{ $topUpAmount }} 
                                            </div>
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
