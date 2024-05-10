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
                            <li class="active">Draft</li>
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
                                            <th>Total Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $index => $order)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $order['order_number'] }}</td>
                                                <td>{{ number_format($order['total_amount'], 0, '.', ',') }} RWF</td>
                                                <td>
                                                    <form method="POST"
                                                        action="
                                                        {{ route('admin.order.list.accept.all', ['id' => $order['order_number']]) }}
                                                        ">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary">
                                                            ACCEPT IT
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <br>
                                <div class="row">
                                    <form action="{{ route('admin.order.list.send') }}" method="POST"
                                        style="display:inline">
                                        @csrf
                                        <div class="col-md-4" style="margin-top: 25px;">

                                            <button type="submit" class="btn btn-primary waves-effect waves-light">ACCEPT
                                                ALL
                                            </button>

                                        </div>
                                    </form>
                                    <div class="col-md-10 text-right">
                                        {{-- <b>TOTAL AMOUNT:</b> {{ number_format($totalAmount, 0, '.', ',') }} RWF --}}

                                    </div>
                                </div>
                            </div>
                            {{-- <div class="text-center">
                                <ul class="pagination">
                                    @if ($pendings->onFirstPage())
                                        <li class="disabled"><span>&laquo;</span></li>
                                    @else
                                        <li><a href="{{ $pendings->previousPageUrl() }}" rel="prev">&laquo;</a>
                                        </li>
                                    @endif

                                    @for ($i = 1; $i <= $pendings->lastPage(); $i++)
                                        <li class="{{ $pendings->currentPage() == $i ? 'active' : '' }}">
                                            <a href="{{ $pendings->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endfor

                                    @if ($pendings->hasMorePages())
                                        <li><a href="{{ $pendings->nextPageUrl() }}" rel="next">&raquo;</a></li>
                                    @else
                                        <li class="disabled"><span>&raquo;</span></li>
                                    @endif
                                </ul>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- container -->
    </div>
@endsection
