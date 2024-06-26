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
                            <div class="col-md-3">
                                <a href="{{ route('admin.reports.index') }}"
                                    class="pull-left page-title btn btn-primary">GENERAL SALES REPORT</a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('admin.reports.orders') }}"
                                    class="pull-left page-title btn btn-secondary">ORDERS REPORT</a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('admin.reports.pendings') }}"
                                    class="pull-left page-title btn btn-secondary">PENDINGS REPORT</a>
                            </div>
                            <div class="col-md-3">
                                <a href="route('seller.reports.partials') }}"
                                    class="pull-left page-title btn btn-secondary">PARTIAL PAYMENT REPORT</a>
                            </div>
                        @else
                            <div class="col-md-3">
                                <a href="{{ route('seller.reports.index') }}"
                                    class="pull-left page-title btn btn-primary">GENERAL DAILY REPORT</a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('seller.reports.orders') }}"
                                    class="pull-left page-title btn btn-secondary">DAILY ORDERS REPORT</a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('seller.reports.pendings') }}"
                                    class="pull-left page-title btn btn-secondary">DAILY PENDINGS REPORT</a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('seller.reports.partials') }}"
                                    class="pull-left page-title btn btn-secondary">DAILY PARTIAL PAYMENT REPORT</a>
                            </div>
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
                                                            <option value="{{ $item->id }}">
                                                                {{ $item->payment_method }}
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
                                                            <option value="{{ $item->id }}">
                                                                {{ $item->insurance_name }}
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
                            <div class="row" style="margin-left: 10px;">
                                @if (auth::user()->role == 'admin')
                                    <div class="col-md-3" style=" margin-top: 20px">
                                    @else
                                        <div class="col-md-9" style=" margin-top: 20px">
                                @endif
                                <a href="{{ route(auth()->user()->role == 'admin' ? 'admin.stats.financial' : 'seller.stats.financial') }}"
                                    class="btn btn-primary"><i class="fa fa-file"></i> FINANCIAL REPORT</a>
                            </div>
                            @if (auth::user()->role == 'admin')
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <div class="color" style="color: #000">From</div>
                                            <input type="date" id="filterFromDate" class="form-control">
                                        </div>
                                        <div class="col-sm-5">
                                            <div class="color" style="color: #000">To</div>
                                            <input type="date" id="filterToDate" class="form-control">
                                        </div>
                                        <div class="col-md-2" style="margin-top: 20px">
                                            <button id="filterBtnDate" class="btn btn-primary">Filter</button>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-5" style="margin-top: 20px">
                                        <button onclick="printTable()" class="btn btn-warning"><i
                                                class="fa fa-download"></i> PRINT</button>
                                    </div>

                                    <div class="col-md-7" style="margin-top: 20px">
                                        <a href="{{ route('download.pdf') }}" class="btn btn-danger"><i
                                                class="fa fa-download"></i> PRINT ALL</a>
                                    </div>
                                </div>
                            </div>



                        </div>

                        {{-- End Filterings --}}


                        <div class="panel-body">
                            <div id="userReport" class="inbox-widget nicescroll mx-box">
                                <table id="salesTable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>N/O</th>
                                            <th colspan="4">PRODUCT INFO</th>
                                            <th>Quantity</th>
                                            @if (Auth::user()->role == 'admin')
                                                <th>Seller</th>
                                            @endif
                                            <th>Price</th>
                                            <th>Insurance</th>
                                            <th>MOMO</th>
                                            <th>POS</th>
                                            <th>CASH</th>
                                            <th>Total</th>
                                            <th>DATE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sales as $index => $item)
                                            <tr data-product-id="{{ $item->product_id }}"
                                                data-insurance-id="{{ $item->insurance_id }}">
                                                <td>{{ $index + 1 }}</td>
                                                @if ($item->product_id == 2)
                                                    <td>{{ $item['lens']['category']['category_name'] ?? '' }}</td>
                                                    <td>{{ $item['lens']['attribute']['attribute_name'] }}</td>
                                                    <td>{{ $item['lens']['power_sph'] }} -
                                                        {{ $item['lens']['power_cyl'] }}</td>
                                                    <td>{{ $item['lens']['power_axis'] }} -
                                                        {{ $item['lens']['power_add'] }}</td>
                                                @else
                                                    <td>{{ $item['item']['category']['category_name'] ?? '' }}</td>
                                                    <td>{{ $item['item']['code_id'] ?? '' }}</td>
                                                    <td>{{ $item['item']['lens_width'] ?? '' }}-{{ $item['item']['bridge_width'] ?? '' }}-{{ $item['item']['temple_length'] ?? '' }}
                                                    </td>
                                                    <td>{{ $item['item']['color']['color_name'] ?? '' }}</td>
                                                @endif
                                                <td>{{ $item['item_quantity'] }}</td>
                                                @if (Auth::user()->role == 'admin')
                                                    <td>{{ $item->user?->seller_name }}</td>
                                                @endif
                                                <td>{{ $item['insurance']['insurance_name'] ?? 'PRIVATE' }}</td>
                                                <td>{{ number_format($item->paymomo, 0, '.', ',') }} RWF
                                                <td>{{ number_format($item->paypos, 0, '.', ',') }} RWF
                                                <td>{{ number_format($item->paycash, 0, '.', ',') }} RWF
                                                </td>


                                                @if ($item->product_id == 2)
                                                    <td>{{ isset($item['lens']['price']) ? number_format($item['lens']['price'], 0, '.', ',') : '' }}
                                                        RWF</td>

                                                    <td>
                                                        @if (isset($item['item_quantity'], $item['lens']['price']))
                                                            {{ number_format($item['item_quantity'] * $item['lens']['price'], 0, '.', ',') }}
                                                            RWF
                                                        @endif

                                                    </td>
                                                @else
                                                    <td>{{ isset($item['item']['price']) ? number_format($item['item']['price'], 0, '.', ',') : '' }}
                                                        RWF</td>

                                                    <td>
                                                        @if (isset($item['item_quantity'], $item['item']['price']))
                                                            {{ number_format($item['item_quantity'] * $item['item']['price'], 0, '.', ',') }}
                                                            RWF
                                                        @endif

                                                    </td>
                                                @endif
                                                <td>{{ date('Y-m-d', strtotime($item['created_at'])) }}</td>
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

                $('#salesTable tbody tr').each(function() {
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
            $('#filterBtnDate').on('click', function() {
                var fromDate = $('#filterFromDate').val();
                var toDate = $('#filterToDate').val();

                $('#salesTable tbody tr').each(function() {
                    var saleDate = $(this).find('td:last')
                        .text(); // Assuming date is in the last column

                    if ((fromDate == '' || saleDate >= fromDate) && (toDate == '' || saleDate <=
                            toDate)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

        });

        function printTable() {
            var divToPrint = document.getElementById("salesTable");
            var newWin = window.open("");
            newWin.document.write("<html><head><title></title>"); // Empty title to avoid the browser adding default title
            newWin.document.write(
                "<style>table { width: 100%; border-collapse: collapse; margin: 0 20px 0 0; } th, td { border: 1px solid black; padding: 5px; text-align: left; } body { display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; padding: 10px 20px; box-sizing: border-box; } .content { text-align: center; width: 100%; } h3 { margin-bottom: 10px; margin-top: 10px; } @page { size: auto; margin: 0; } header, footer { display: none; }</style>"
            );
            newWin.document.write("</head><body>");
            newWin.document.write("<div class='content'>");
            newWin.document.write("<h3>SALES REPORT</h3>");
            newWin.document.write(divToPrint.outerHTML);
            newWin.document.write("</div>");
            newWin.document.close();
            newWin.print();
        }
    </script>
@endsection
