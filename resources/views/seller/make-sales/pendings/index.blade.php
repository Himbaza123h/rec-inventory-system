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
                        <h3 class="page-title"><b>PENDING LIST</b></h3>
                    </div>
                    <div class="col-sm-8">
                        <ol class="breadcrumb pull-right">
                            <li><a href="{{ route('home') }}">Home</a></li>
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
                                            <th>INSURANCE</th>
                                            <th>PATIENT</th>
                                            <th>PRODUCT</th>
                                            <th>INSURANCE AMOUNT</th>
                                            <th>PENDING AMOUNT</th>
                                            <th class="text-center">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $index => $order)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $order['insurance']['insurance_name'] }}</td>
                                                <td>{{ $order['customer']['customer_name'] }}</td>
                                                <td>
                                                    @if ($order['product'] == 1)
                                                        FRAMES
                                                    @elseif ($order['product'] == 2)
                                                        LENS
                                                    @elseif ($order['product'] == 3)
                                                        SUN GLASSES
                                                    @else
                                                        READING GLASSES
                                                    @endif
                                                </td>
                                                <td>{{ number_format($order['covered'], 0, '.', ',') }} RWF</td>
                                                <td>{{ number_format($order['total_amount'] - $order['covered'], 0, '.', ',') }}
                                                    RWF</td>



                                                <td class="text-center">
                                                    <a href="{{ route('seller.pendings.orders.edit', ['id' => $order['order_number']]) }}"
                                                        class="btn btn-success waves-effect waves-light">VIEW &
                                                        CONFIRM</a>&nbsp;

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
