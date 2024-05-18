@extends('layouts.app')

@section('page-title')
{{ __('Reports') }}
@endsection

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    @if (Auth::user()->role == 'admin')
                    <h4 class="pull-left page-title">SALES REPORT</h4>
                    @else
                    <h4 class="pull-left page-title">DAILY REPORT</h4>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-sm-3" style="margin-bottom: 10px">
                                    <div class="panel-heading" style="background-color: #3e4550;">
                                        <div class="row" style="color: #ffffff;">
                                            <div class="col-md-12">
                                                @php
                                                $products = \App\Models\Product::where('status', true)->get();
                                                @endphp
                                                SELECT PRODUCT
                                                <select class="select2 form-control" name="product" id="product">
                                                    <option>Choose Product</option>
                                                    @foreach ($products as $item)
                                                    <option value="{{ $item->id }}">{{ $item->product_name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                {{-- By Mode of Payment --}}

                                <div class="col-sm-3" style="margin-bottom: 10px">
                                    <div class="panel-heading" style="background-color: #3e4550;">
                                        <div class="row" style="color: #ffffff;">
                                            <div class="col-md-12">
                                                @php
                                                $payments = \App\Models\Payment::where('status', true)->get();
                                                @endphp
                                                PAID BY
                                                <select class="select2 form-control" name="payment" id="payment">
                                                    <option>Choose Payement mode</option>
                                                    @foreach ($payments as $item)
                                                    <option value="{{ $item->id }}">{{ $item->payment_method }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                {{-- By  Insurance --}}

                                <div class="col-sm-3" style="margin-bottom: 10px">
                                    <div class="panel-heading" style="background-color: #3e4550;">
                                        <div class="row" style="color: #ffffff;">
                                            <div class="col-md-12">
                                                @php
                                                $insurances = \App\Models\Insurance::where(
                                                'status',
                                                true,
                                                )->get();
                                                @endphp
                                                INSURENCE
                                                <select class="select2 form-control" name="insurance" id="insurance">
                                                    <option>Choose Insurance</option>
                                                    @foreach ($insurances as $item)
                                                    <option value="{{ $item->id }}">{{ $item->insurance_name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2" style="margin-top: 30px">
                                    <button id="filterBtn" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </div>


                        {{-- Filterings --}}
                        <br>
                        <div class="row" style="margin-left: 10px">
                            <div class="col-md-3">
                                <a href="{{ route(auth()->user()->role == 'admin' ? 'admin.stats.financial' : 'seller.stats.financial') }}" class="btn btn-primary"><i class="fa fa-file"></i> FINANCIAL REPORT</a>
                            </div>
                        </div>

                        {{-- End Filterings --}}


                        <div class="panel-body">
                            <div id="userReport" class="inbox-widget nicescroll mx-box">
                                <table id="datatable-buttons" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>N/O</th>
                                            <th colspan="4">PRODUCT INFO</th>
                                            <th>Quantity</th>
                                            @if (Auth::user()->role == 'admin')
                                            <th>Seller</th>
                                            @endif
                                            <th>Price</th>
                                            <th>Total</th>
                                            <th>Insurance</th>
                                            <th>Paid By</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sales as $index => $item)
                                        <tr data-product-id="{{ $item->product_id }}" data-insurance-id="{{ $item->insurance_id }}">
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item['item']['category']['category_name'] ?? '' }}</td>
                                            <td>{{ $item['item']['code']['code_name'] ?? '' }}</td>
                                            <td>{{ $item['item']['lens_width'] ?? '' }}-{{ $item['item']['bridge_width'] ?? '' }}-{{ $item['item']['temple_length'] ?? '' }}</td>
                                            <td>{{ $item['item']['color']['color_name'] ?? '' }}</td>
                                            <td>{{ $item['item_quantity'] }}</td>
                                            @if (Auth::user()->role == 'admin')
                                            <td>{{ $item->user?->seller_name }}</td>
                                            @endif
                                            <td>{{ $item['item']['price'] ?? '' }} RWF</td>
                                            <td>
                                                @if(isset($item['item_quantity'], $item['item']['price']))
                                                {{ $item['item_quantity'] * $item['item']['price'] }} RWF
                                                @endif
                                            </td>
                                            <td>{{ $item['insurance']['insurance_name'] ?? 'PRIVATE' }}</td>
                                            <td>
                                                @if ($item->paypos)
                                                POS
                                                @endif
                                                @if ($item->paymomo)
                                                @if ($item->paypos)
                                                ,
                                                @endif
                                                MOMO
                                                @endif
                                                @if ($item->paycash)
                                                @if ($item->paypos || $item->paymomo)
                                                ,
                                                @endif
                                                Cash
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <div class="text-center">
                                <ul class="pagination">
                                    @if ($sales->onFirstPage())
                                    <li class="disabled"><span>&laquo;</span></li>
                                    @else
                                    <li><a href="{{ $sales->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                                    @endif

                                    @for ($i = 1; $i <= $sales->lastPage(); $i++)
                                        <li class="{{ $sales->currentPage() == $i ? 'active' : '' }}">
                                            <a href="{{ $sales->url($i) }}">{{ $i }}</a>
                                        </li>
                                        @endfor

                                        @if ($sales->hasMorePages())
                                        <li><a href="{{ $sales->nextPageUrl() }}" rel="next">&raquo;</a></li>
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
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#filterBtn').on('click', function() {
            var selectedProductId = $('#product').val();
            var selectedPaymentId = $('#payment').val();
            var selectedInsuranceId = $('#insurance').val();

            $('#datatable-buttons tbody tr').each(function() {
                var productId = $(this).data('product-id');
                var insuranceId = $(this).data('insurance-id');

                var productMatch = (selectedProductId == 'Choose Product' || productId ==
                    selectedProductId);
                var insuranceMatch = (selectedInsuranceId == 'Choose Insurance' ||
                    insuranceId == selectedInsuranceId);
                if (productMatch && insuranceMatch) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
</script>
@endsection