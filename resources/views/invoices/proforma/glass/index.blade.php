@extends('layouts.app')
@section('page-title')
    {{ __('Glass Performa') }}
@endsection

@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">

                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="pull-left page-title"><b>INVOICES</b></h4>
                        <ol class="breadcrumb pull-right">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li class="active">Invoices</li>
                        </ol>
                    </div>
                </div>
                <!-- Page-Title -->
                <div class="row">
                    <!-- USER LIST -->
                    <div class="col-lg-3 hidden-print">
                        <div class="panel panel-inverse">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h4 class="panel-title" style="color: #fff;">INVOICES</h4>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <input type="text" id="searchInvoice" onkeyup="search()"
                                                name="example-input1-group2" class="form-control input-sm"
                                                placeholder="Search...">
                                            <span class="input-group-btn">
                                                <button type="button"
                                                    class="btn-sm btn waves-effect waves-light btn-primary"><i
                                                        class="fa fa-search"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div id="userResults" class="inbox-widget nicescroll mx-box">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>N/O</th>
                                                <th>SALE CODE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($invoices as $index => $invoice)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>
                                                        <a
                                                            href=
                                                            {{-- "{{ route(auth()->user()->role . '.invoice-by-sell-code.index', ['id' => $invoice->sale_code]) }}" --}}
                                                            >
                                                            {{ $invoice->sale_code }}
                                                        </a>
                                                    </td>


                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-md-9">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                @if ($data == null)
                                    Nothing to display here
                                @else
                                    <table border="1" width="100%">
                                        <tr>
                                            <th colspan="8">
                                                <h4 class="text-center">Invoice Details</h4>
                                                <div class="clearfix">
                                                    <div class="pull-left" style="margin: 10px">
                                                        <strong>{{ strtoupper(env('APP_NAME')) }}</strong><br>
                                                        <strong>Address: Kigali Rwanda</strong><br>
                                                        <strong>Mobile: {{ auth()->user()->phone }}</strong><br>
                                                        <strong>Email: {{ auth()->user()->email }}</strong><br>
                                                        {{-- <strong>Purchase Number:
                                                        {{ $data }}</strong><br> --}}
                                                    </div>
                                                    <div class="pull-right">
                                                        <img src="{{ asset('assets/images/electric.jpg') }}" height="100"
                                                            width="200" alt="LOGO">
                                                    </div>
                                                </div>
                                            </th>

                                        <tr style="height:20px">
                                            <th colspan="8"></th>
                                        </tr>
                                        <tr>
                                            <th>#</th>
                                            <th>ITEM INFO</th>
                                            <th>QUANTITY</th>
                                            <th>PRICE</th>
                                        </tr>
                                        @php
                                            $totalPrice = 0;
                                        @endphp
                                        <tbody>
                                            @foreach ($data as $index => $item)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $item->item?->category?->category_name }}</td>
                                                    <td>{{ $item->qty }}</td>
                                                    <td>{{ $item->price }}RWF</td>
                                                </tr>
                                                @php
                                                    $totalPrice += $item->qty * $item->price;
                                                @endphp
                                            @endforeach

                                        </tbody>

                                        <tr>
                                            <th colspan="2">
                                                Bank of Kigali XXXXX-XXXXXXXX-XX/RWF<br>
                                                Account Name: RWANDA EYE CLINIC<br>
                                                RWANDA EYE CLINIC
                                            </th>
                                            <th colspan="2">TOTAL PRICE: {{ $totalPrice }} RWF</th>
                                        </tr>
                                    </table>
                            </div>
                            <hr>
                            <div class="hidden-print">
                                <div class="pull-right">
                                    <a href="javascript:window.print()" class="btn btn-inverse waves-effect waves-light"><i
                                            class="fa fa-print"></i></a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
