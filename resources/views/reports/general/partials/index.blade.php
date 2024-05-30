@extends('layouts.app')

@section('page-title')
    {{ __('Partial Payments Reports') }}
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
                                    class="pull-left page-title btn btn-secondary">GENERAL SALES REPORT</a>
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
                                <a href="{{ route('admin.reports.partials') }}"
                                    class="pull-left page-title btn btn-primary">PARTIAL PAYMENT REPORT</a>
                            </div>
                        @else
                            <div class="col-md-3">
                                <a href="{{ route('seller.reports.index') }}"
                                    class="pull-left page-title btn btn-secondary">GENERAL DAILY REPORT</a>
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
                                    class="pull-left page-title btn btn-primary">DAILY PARTIAL PAYMENT REPORT</a>
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
                                            <th>ORDER CODE</th>
                                            <th>CUSTOMER</th>
                                            <th colspan="3">PRODUCT</th>
                                            <th>QUANTITY</th>
                                            <th>MOMO</th>
                                            <th>POS</th>
                                            <th>CASH</th>
                                            <th>TOTAL AMOUNT</th>
                                            <th>AMOUNT PAID</th>
                                            <th>PENDING AMOUNT</th>
                                            <th>DATE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $index => $order)
                                            @php

                                                $AmountPaid =
                                                    $order->payment_method_pos +
                                                    $order->payment_method_momo +
                                                    $order->payment_method_cash;
                                                // Fetch OrderItems for the current order code
                                                $orderItems = \App\Models\OrderItem::where(
                                                    'order_code',
                                                    $order->order_code,
                                                )->get();
                                                // Calculate total quantity and total amount for the order
                                                $totalQuantity = $orderItems->sum('quantity');
                                                $totalAmount = $orderItems->sum('amount');
                                                $pendingAmount = $totalAmount - $AmountPaid;
                                            @endphp
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $order->order_code }}</td>
                                                <td>{{ $order->buyer->customer_name ?? '' }}</td>
                                                <td colspan="3">
                                                    @foreach ($orderItems as $item)
                                                        {{ $item->item->type->type_name }} -
                                                        {{ $item->item->attribute->attribute_name }}
                                                        - {{ $item->item->category->category_name }} <br>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($orderItems as $item)
                                                        {{ $item->quantity }}<br>
                                                    @endforeach
                                                </td>
                                                <td>{{ number_format($order->payment_method_momo, 0, '.', ',') }} RWF
                                                </td>
                                                <td>{{ number_format($order->payment_method_pos, 0, '.', ',') }} RWF
                                                </td>
                                                <td>{{ number_format($order->payment_method_cash, 0, '.', ',') }} RWF
                                                </td>
                                                <td>{{ number_format($totalAmount, 0, '.', ',') }} RWF</td>
                                                <td>{{ number_format($AmountPaid, 0, '.', ',') }} RWF</td>
                                                <td>{{ number_format(max(0, $pendingAmount), 0, '.', ',') }} RWF</td>
                                                <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                            {{-- <div class="text-center">
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
                            </div> --}}
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
