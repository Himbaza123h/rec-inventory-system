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
                            <li><a href="{{ route('admin.purchase.order.index') }}">Orders</a></li>
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
                                            <th>ORDER NUMBER</th>
                                            <th>SUPPLIER NAME</th>
                                            <th>Total Amount</th>
                                            <th>DATE</th>
                                            <th>STATUS</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $index => $order)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $order['order_number'] }}</td>
                                                <td>{{ $order['supplier']['supplier_name'] }}</td>
                                                <td>{{ number_format($order['total_amount'], 0, '.', ',') }} RWF</td>
                                                <td>{{ $order['order_date'] }}</td>
                                                <td>
                                                    @if ($order['status'] == 2)
                                                        Pending
                                                    @elseif ($order['status'] == 5)
                                                        @if ($order['prefix'] == 1)
                                                            Paid
                                                        @elseif ($order['prefix'] == 0)
                                                            to be paid
                                                        @endif
                                                    @else
                                                        {{ $order['status'] }}
                                                    @endif
                                                </td>
                                                @if ($order['status'] == 2)
                                                    <td class="text-center">
                                                        <a href="{{ route('admin.single.order.list', ['id' => $order['order_number']]) }}"
                                                            class="btn btn-success waves-effect waves-light">VIEW &
                                                            CONFIRM</a>&nbsp;

                                                        <!-- <a href="" class="btn btn-warning">CONFIRM</a> -->
                                                    </td>
                                                @elseif ($order['status'] == 5)
                                                    @if ($order['prefix'] == 1)
                                                        <td class="text-center">{{ __('Paid') }}</td>
                                                    @elseif ($order['prefix'] == 0)
                                                        <td class="text-center">
                                                            <form
                                                                action="{{ route('admin.single.order.reconfirm', ['id' => $order['order_number']]) }}"
                                                                method="POST" style="display:inline">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit"
                                                                    class="btn btn-warning waves-effect waves-light">MARK AS
                                                                    PAID</button>
                                                            </form>

                                                        </td>
                                                    @endif
                                                @else
                                                    {{ $order['status'] }}
                                                @endif
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
