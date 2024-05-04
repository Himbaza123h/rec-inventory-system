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
                            <li><a href="{{ route('admin.purchase.index') }}">Orders</a></li>
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
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $totalAmount = 0; ?>
                                        @foreach ($pendings as $index => $item)
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
                                                <td>
                                                    <form
                                                        action="{{ route('admin.delete.order.detail', ['id' => $item->id]) }}"
                                                        method="POST" style="display:inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-danger waves-effect waves-light">Remove</button>
                                                    </form>
                                                    &nbsp;
                                                    <button class="btn btn-success waves-effect waves-light">change</button>
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
                                        <div class="col-md-4">
                                            @php
                                                $suppliers = \App\Models\Supplier::where('status', true)->get();
                                            @endphp
                                            <label for="supplier">Supplier</label>
                                            <select name="supplier_id" id="" class="select2 form-control">
                                                <option value="">Choose Supplier</option>
                                                @foreach ($suppliers as $item)
                                                    <option value="{{ $item->id }}">{{ $item->supplier_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4" style="margin-top: 25px;">

                                            <button type="submit" class="btn btn-primary waves-effect waves-light">SEND
                                                ORDER</button>

                                        </div>
                                    </form>
                                    <div class="col-md-10 text-right">
                                        <b>TOTAL AMOUNT:</b> {{ number_format($totalAmount, 0, '.', ',') }} RWF

                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- container -->
    </div>
@endsection
