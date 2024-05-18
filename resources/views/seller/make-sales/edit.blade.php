@extends('layouts.app')

@section('page-title')
    {{ __('Confirm Checkout') }}
@endsection



@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">

                <!-- Page-Title -->


                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="pull-left page-title"><b> SALE</b><i class="ion-ios7-cart-outline"></i></h3>
                        <ol class="breadcrumb pull-right">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route('seller.make.sales.index') }}">Sales</a></li>
                            <li class="active">Details</li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <!-- USER LIST -->
                    <div class="col-lg-4 hidden-print">
                        <div class="panel panel-inverse" style="height: 680px">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="panel-title" style="color: #fff;">CONFIRM CHECKOUT</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div id="userResurts" class="inbox-widget nicescroll mx-box">
                                    <form action="{{ route('seller.checkout.update', ['id' => $data[0]->sale_code]) }}"
                                        method="POST">
                                        @csrf
                                        <input type="hidden" name="_method" value="PUT">

                                        <div class="row">
                                            <div class="col-md-12">
                                                @php
                                                    $operators = \App\Models\Seller::where('status', true)->get();
                                                @endphp
                                                <label for="payment_method">OPERATOR </label><br>
                                                <select name="operator_id" id="seller" class="select2 form-control">
                                                    <option>Choose Operator</option>
                                                    @foreach ($operators as $item)
                                                        <option value="{{ $item->id }}">{{ $item->seller_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            @php
                                                $customer = \App\Models\Customer::all();
                                            @endphp
                                            <div class="col-md-9">
                                                <label for="payment_method">CUSTOMER</label><br>
                                                <select name="buyer_id" id="target_client" class="select2 form-control">
                                                    <option value="">Select Customer</option>
                                                    @foreach ($customer as $person)
                                                        <option value="{{ $person->id }}">{{ $person->customer_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-2" style="margin-top: 6px">
                                                <label for=""></label>
                                                <a href="{{ route('seller.customers.index') }}"
                                                    class="btn btn-primary waves-effect waves-light">New
                                                    <i class="fa fa-plus"></i></a>
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="insurance_percentage">Insurance (%)</label><br>
                                                <select id="insurance_percentage" class="select2 form-control">
                                                    <option value="0">Select</option>
                                                    <option value="5">5</option>
                                                    <option value="10">10</option>
                                                    <option value="15">15</option>
                                                    <option value="20">20</option>
                                                    <option value="25">25</option>
                                                    <option value="30">30</option>
                                                    <option value="35">35</option>
                                                    <option value="40">40</option>
                                                    <option value="45">45</option>
                                                    <option value="50">50</option>
                                                </select>
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="ticket_moderateur">Ticket Modérateur</label><br>
                                                <input type="text" id="ticket_moderateur" class="form-control"
                                                    placeholder="0" disabled />
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="ticket_moderateur">TopUp</label><br>
                                                <input type="text" id="amount_to_pay" class="form-control"
                                                    placeholder="0" disabled />
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                @php
                                                    $payments = \App\Models\Payment::where('status', true)->get();
                                                @endphp
                                                <label for="payment_method">PAYMENT METHOD </label><br>
                                                <select name="payment_method" class="select2 form-control" id="trackMode">
                                                    <option>Choose Payment</option>
                                                    @foreach ($payments as $item)
                                                        <option value="{{ $item->id }}">{{ $item->payment_method }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="row"><br>
                                                    <div id="paymentInputs"></div>
                                                </div>
                                                <input type="hidden" name="paypos" id="paypos_input">
                                                <input type="hidden" name="paymomo" id="paymomo_input">
                                                <input type="hidden" name="paycash" id="paycash_input">
                                            </div>
                                        </div><br>
                                        <button type="submit" class="btn btn-success waves-effect waves-light"
                                            id="purchase_item">CONFIRM <i class="ion-ios7-cart-outline"></i></button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                    <div class="col-md-8">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <table border="1" width="100%">
                                    <tr>
                                        <th colspan="8">
                                            <h4 class="text-center">SALE INFORMATION</h4>
                                            <div class="clearfix">
                                                <div class="pull-left" style="margin: 10px">
                                                    <strong>{{ strtoupper(env('APP_NAME')) }}</strong><br>
                                                    <strong>Address: Kigali Rwanda</strong><br>
                                                    <strong>Mobile: {{ auth()->user()->phone }}</strong><br>
                                                    <strong>Email: {{ auth()->user()->email }}</strong><br>
                                                    <strong>Sale Number:
                                                        {{ $data[0]->sale_code }}</strong><br>
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
                                        <th colspan="3" class="text-center">ITEM INFO</th>
                                        <th>QUANTITY</th>
                                        <th>PRICE</th>
                                    </tr>
                                    <tbody>
                                        @php
                                            $totalPrice = 0;
                                            $covered = 0;
                                        @endphp
                                        @foreach ($data as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                @if ($item->product_id == 1 || $item->product_id == 3 || $item->product_id == 4)
                                                    <td>{{ $item->item?->category?->category_name }}</td>
                                                    <td>{{ $item->item?->code_id }}</td>
                                                    <td>{{ $item->item?->lens_width }}-{{ $item->item?->bridge_width }}-{{ $item->item?->temple_length }}
                                                    </td>
                                                @elseif($item->product_id == 2)
                                                    <td>{{ $item->lens->category->category_name }}</td>
                                                    <td>{{ $item->lens->attribute?->attribute_name }}</td>
                                                    <td>{{ $item->lens?->power_sph }}-{{ $item->lens?->power_cyl }}-{{ $item->lens?->power_axis }}-{{ $item->lens?->power_add }}
                                                    </td>
                                                @endif
                                                <td>{{ $item->qty }}</td>
                                                <td>{{ $item->price }}</td>
                                                <td class="covered" style="display: none;">{{ $item->covered }}</td>
                                            </tr>
                                            @php
                                                $totalPrice += $item->qty * $item->price;
                                                $covered += $item->covered;
                                                $formattedTotalPrice = number_format($totalPrice) . 'RWF';
                                                $formattedCovered = number_format($covered) . 'RWF';

                                                $toUup = $totalPrice - $covered;
                                                $topUpAmount = number_format($toUup) . 'RWF';

                                            @endphp
                                        @endforeach

                                    </tbody>

                                    <tr>
                                        <th colspan="5">
                                            Bank of Kigali XXXXX-XXXXXXXX-XX/RWF<br>
                                            Account Name: RWANDA EYE CLINIC<br>
                                            RWANDA EYE CLINIC
                                        </th>
                                        <th colspan="2">
                                            <div class="" style="margin-left: 10px">
                                                TOTOL PRICE: {{ $formattedTotalPrice }}<br>
                                                INSURANCE AMOUNT: {{ $formattedCovered }} <br>
                                                TOP UP AMOUNT: {{ $topUpAmount }}
                                            </div>
                                    </tr>
                                </table>
                            </div>
                            <hr>
                            <div class="hidden-print">
                                <div class="pull-right">
                                    <a href="javascript:window.print()"
                                        class="btn btn-inverse waves-effect waves-light"><i class="fa fa-print"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- container -->
    </div>
    <!-- Inside the JavaScript -->
    <script>
        $(document).ready(function() {
            $("#trackMode").change(function() {
                var mode = $(this).val();

                if (mode === "1") {
                    $("#paymentInputs").append(
                        '<div class="col-lg-4"><input type="text" class="form-control cash-input" name="paycash" placeholder="Momo"><button type="button" class="remove-input btn btn-danger"><i class="fa fa-times"></i></button></div>'
                    );
                } else if (mode === "2") {
                    $("#paymentInputs").append(
                        '<div class="col-lg-4"><input type="text" class="form-control momo-input" name="paymomo" placeholder="Cash"><button type="button" class="remove-input btn btn-danger"><i class="fa fa-times"></i></button></div>'
                    );
                } else if (mode === "3") {
                    $("#paymentInputs").append(
                        '<div class="col-lg-4"><input type="text" class="form-control three-input" name="paypos" placeholder="POS"><button type="button" class="remove-input btn btn-danger"><i class="fa fa-times"></i></button></div>'
                    );
                }
            });

            $(document).on("click", ".remove-input", function() {
                $(this).closest(".col-lg-4").remove();
            });

            // Update hidden input fields when values change
            $(document).on("input", ".cash-input", function() {
                $("#paycash_input").val($(this).val());
            });

            $(document).on("input", ".momo-input", function() {
                $("#paymomo_input").val($(this).val());
            });

            $(document).on("input", ".three-input", function() {
                $("#paypos_input").val($(this).val());
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            const insuranceSelect = $('#insurance_percentage');
            const ticketModerateurInput = $('#ticket_moderateur');
            const coveredElements = $('.covered');
            const amountToPayInput = $('#amount_to_pay');

            function updateTicketModerateur() {
                console.log('Updating ticket modérateur');
                const selectedPercentage = parseFloat(insuranceSelect.val());
                const totalCovered = Array.from(coveredElements).reduce((acc, td) => acc + parseFloat($(td).text()),
                    0);
                const ticketModerateur = (totalCovered * selectedPercentage) / 100;
                ticketModerateurInput.val(ticketModerateur.toFixed(2));

                const totalPrice = parseFloat('{{ $totalPrice }}');
                const amountToPay = totalPrice - totalCovered + ticketModerateur;
                amountToPayInput.val(amountToPay.toFixed(2));
            }

            insuranceSelect.on('change', updateTicketModerateur);
            updateTicketModerateur();
        });
    </script>
@endsection
