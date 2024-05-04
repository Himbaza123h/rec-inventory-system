@extends('layouts.app')

@section('page-title')
    {{ __('Confirm list details') }}
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
                            <li><a href="{{ route('admin.confirm.orders') }}">Orders</a></li>
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
                                            <th colspan="3">PRODUCT INFO</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $totalAmount = 0; ?>
                                        @foreach ($orderList as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                @if ($item->product_id == 2)
                                                    <td>{{ $item->lens?->category?->category_name }}</td>
                                                    <td>{{ $item->lens?->attribute?->attribute_name }}</td>
                                                    <td>{{ $item->lens?->lens_power }}</td>
                                                @else
                                                    <td>{{ $item->item?->category?->category_name }}</td>
                                                    <td>{{ $item->item?->code?->code_name }}</td>
                                                    <td>{{ $item['item']['lens_width'] }}-{{ $item['item']['bridge_width'] }}-{{ $item['item']['temple_length'] }}
                                                    </td>
                                                @endif
                                                <td>{{ $item->qty }}</td>
                                                <td>{{ $item->price }}</td>
                                                <td>{{ $item->amount }}</td>
                                                <?php $totalAmount += $item->amount; ?>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <br>
                                <div class="row">
                                    <form action="{{ route('admin.single.order.confirm', ['id' => $id]) }}" method="POST"
                                        style="display:inline">
                                        @csrf
                                        @method('PUT')

                                        <div class="col-md-4">
                                            @php
                                                $payemnts = \App\Models\Payment::where('status', true)->get();
                                            @endphp
                                            <label for="payment_method">Payment</label>
                                            <select name="payment_method" id="" class="select2 form-control">
                                                <option value="">Choose </option>
                                                @foreach ($payemnts as $item)
                                                    <option value="{{ $item->id }}">{{ $item->payment_method }}
                                                    </option>
                                                @endforeach
                                                {{-- <option value="">PAY NOW</option>
                                                <option value="">PAY LATER</option> --}}
                                            </select>
                                        </div>
                                        <div class="col-md-4" style="margin-top: 25px;">

                                            <button type="submit" class="btn btn-success waves-effect waves-light">CONFIRM
                                                ORDER</button>

                                        </div>
                                    </form>
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
