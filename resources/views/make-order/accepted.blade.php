@extends('layouts.app')

@section('page-title')
    {{ __('order list details') }}
@endsection

@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <h3 class="page-title"><b>ORDERS LIST</b></h3>
                    </div>
                    <div class="col-sm-8">
                        <ol class="breadcrumb pull-right">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route('seller.make.order') }}">Orders</a></li>
                            <li class="active">Pending</li>
                        </ol>
                    </div>
                </div>





            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body" style="height: 120vh;">
                            <div id="userReport" class="inbox-widget nicescroll mx-box">
                                <table id="datatable-buttons" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>N/O</th>
                                            <th>PATIENT</th>
                                            <th>PRODUCT</th>
                                            <th>Total Amount</th>
                                            <th>Amount Paid</th>
                                            <th>Pending Amount</th>
                                            <th>DATE</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $index => $order)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $order['buyer']['customer_name'] }}</td>
                                                <td>{{ __('LENS') }}</td>
                                                <td>{{ number_format($order['totalAmount'], 0, '.', ',') }}RWF</td>
                                                <td>{{ number_format($order['payment_method_pos'] + $order['payment_method_momo'] + $order['payment_method_cash'], 0, '.', ',') }}
                                                    RWF</td>
                                                <td>
                                                    {{ number_format(
                                                        max(
                                                            0,
                                                            $order['totalAmount'] -
                                                                ($order['payment_method_pos'] + $order['payment_method_momo'] + $order['payment_method_cash']),
                                                        ),
                                                        0,
                                                        '.',
                                                        ',',
                                                    ) }}
                                                    RWF
                                                </td>

                                                <td>{{ $order['created_at'] }}</td>
                                                <td>
                                                    <form
                                                        action="{{ route('seller.confirm.order', ['id' => $order['order_code']]) }}"
                                                        method="POST" style="display:inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit"
                                                            class="btn btn-warning waves-effect waves-light">CONFIRM</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- container -->
    </div>
@endsection
