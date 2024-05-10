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
                        <h3 class="page-title"><b>ORDER LIST</b></h3>
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
                        <div class="panel-body">
                            <div id="userReport" class="inbox-widget nicescroll mx-box">
                                <table id="datatable-buttons" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>N/O</th>
                                            <th>ORDER NUMBER</th>
                                            {{-- <th>SUPPLIER</th> --}}
                                            <th>Total Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $index => $order)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $order['order_number'] }}</td>
                                                {{-- <td>{{ $order['supplier'] }}</td> --}}
                                                <td>{{ number_format($order['total_amount'], 0, '.', ',') }} RWF</td>
                                                <td>
                                                    <a href="{{ route('admin.single.order.list', ['id' => $order['order_number']]) }}"
                                                        class="btn btn-success waves-effect waves-light">VIEW</a>&nbsp;

                                                    <a href="" class="btn btn-warning">CONFIRM</a>
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
