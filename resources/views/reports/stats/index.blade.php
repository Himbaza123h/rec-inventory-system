@extends('layouts.app')

@section('page-title')
    {{ __('Financial Report') }}
@endsection

@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <h3 class="page-title"><b>FINANCIAL REPORT</b></h3>
                    </div>
                    @if (Auth::user()->role == 'admin')
                        <div class="col-md-2">
                            <label for="">DATE</label>
                            <div class="input-group">
                                <input type="date" id="toDate" class="form-control input-sm">
                            </div>
                        </div>
                        <br>
                        <div class="col-md-2">
                            <button class="btn btn-primary">Search</button>
                        </div>
                    @endif

                    <div class="col-sm-8">
                        <ol class="breadcrumb pull-right">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route('admin.reports.index') }}">Reports</a></li>
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
                                            <th>DATE</th>
                                            <th>CASH</th>
                                            <th>MOMO</th>
                                            <th>POS</th>
                                            <th>ASSURANCE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td>{{ $order->date }}</td>
                                                <td>{{ number_format($order->cash, 0, '.', ',') }} RWF</td>
                                                <td>{{ number_format($order->momo, 0, '.', ',') }} RWF</td>
                                                <td>{{ number_format($order->pos, 0, '.', ',') }} RWF</td>
                                                <td>
                                                    @php
                                                        $insurance = \App\Models\Insurance::find($order->assurance);
                                                        // $amount = \App\Models\CartItem::where('item_id', );
                                                    @endphp
                                                    @if ($insurance)
                                                        {{ $insurance->insurance_name }} :
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <br>
                                <div class="row">
                                    <div class="col-md-10 text-right">
                                        <b>TOTAL AMOUNT:</b> {{ number_format($totalAmount, 0, '.', ',') }} RWF
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- container -->
    </div>
@endsection
