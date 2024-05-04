@extends('layouts.app')

@section('page-title')
    {{ __('Confirm Orders') }}
@endsection

@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <h3 class="page-title"><b>ACCEPTED ORDERS</b></h3>
                    </div>
                    <div class="col-sm-8">
                        <ol class="breadcrumb pull-right">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route('admin.purchase.index') }}">Orders</a></li>
                            <li class="active">accepted</li>
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
                                            <th>ORDER NAME</th>
                                            <th>SUPPLIER</th>
                                            <th>AMOUNT</th>
                                            <th>CREATED DATE</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $groupedData = $accepted->groupBy('order_id');
                                        @endphp
                                        @foreach ($groupedData as $index => $items)
                                            <tr>
                                                <td rowspan="{{ $items->count() }}">{{ $loop->iteration }}</td>
                                                @foreach ($items as $innerIndex => $item)
                                            <tr>
                                                @if ($innerIndex === 0)
                                                    <td rowspan="{{ $items->count() }}">Order {{ $item->order_id }}</td>
                                                    <td rowspan="{{ $items->count() }}">{{ $item->user->supplier_name }}
                                                    </td>
                                                    <td rowspan="{{ $items->count() }}">
                                                        {{ number_format($items->sum('amount'), 0, '.', ',') }} RWF
                                                    </td>
                                                    <td rowspan="{{ $items->count() }}">{{ $item->created_at }}</td>
                                                    <td rowspan="{{ $items->count() }}">
                                                        <a href="{{ route('admin.single.order.list', ['id' => $item->order_id]) }}"
                                                            class="btn btn-success waves-effect waves-light">VIEW</a>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <br>
                            </div>
                            <div class="text-center">
                                <ul class="pagination">
                                    @if ($accepted->onFirstPage())
                                        <li class="disabled"><span>&laquo;</span></li>
                                    @else
                                        <li><a href="{{ $accepted->previousPageUrl() }}" rel="prev">&laquo;</a>
                                        </li>
                                    @endif

                                    @for ($i = 1; $i <= $accepted->lastPage(); $i++)
                                        <li class="{{ $accepted->currentPage() == $i ? 'active' : '' }}">
                                            <a href="{{ $accepted->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endfor

                                    @if ($accepted->hasMorePages())
                                        <li><a href="{{ $accepted->nextPageUrl() }}" rel="next">&raquo;</a></li>
                                    @else
                                        <li class="disabled"><span>&raquo;</span></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- container -->
    </div>
@endsection
