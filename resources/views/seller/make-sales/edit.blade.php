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
                                        @php
                                            $totalPrice = 0;
                                            $covered = 0;
                                            foreach ($data as $item) {
                                                $totalPrice += $item->amount;
                                                $covered += $item->covered;
                                            }
                                            $toUp = $totalPrice - $covered;
                                        @endphp

                                        <input type="hidden" name="covered_hidden" value="{{ $toUp }}">
                                        <div class="row">
                                            <div class="col-md-12">
                                                @php
                                                    $operators = \App\Models\Seller::where('status', true)->get();
                                                @endphp
                                                <label for="payment_method">OPERATOR</label><br>
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
                                                <a href="{{ route('seller.customers.append', ['sale_code' => $data[0]->sale_code]) }}"
                                                    class="btn btn-primary waves-effect waves-light">New
                                                    <i class="fa fa-plus"></i></a>
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="insurance_percentage">Insurance (%)</label><br>
                                                <select id="insurance_percentage" class="select2 form-control"
                                                    name="insurance_percentage">
                                                    <option value="0">Select</option>
                                                    @for ($i = 5; $i <= 50; $i += 5)
                                                        <option value="{{ $i }}">{{ $i }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="ticket_moderateur">Ticket Modérateur</label><br>
                                                <input type="text" id="ticket_moderateur" name="ticket_moderateur"
                                                    class="form-control" placeholder="0" disabled />
                                            </div>

                                            <div class="col-md-6">
                                                <label for="top_up">TopUp</label><br>
                                                <input type="text" id="top_up" name="top_up_amount"
                                                    class="form-control" value="{{ $toUp }}"
                                                    placeholder="{{ $toUp }}" disabled />
                                            </div>
                                        </div><br>

                                        <div class="row" id="total_amount_field">
                                            <label for="total_amount">Total Amount to Pay</label>
                                            <input type="text" class="form-control" id="total_amount" name="total_amount"
                                                value="{{ number_format($toUp, 0, '.', ',') }} RWF" disabled>
                                        </div> <br>
                                        <input type="hidden" name="updated_total_amount" id="updated_total_amount_input">

                                        <script>
                                            // Function to calculate ticket modérateur and update UI
                                            function calculateTicketModulateur(percentage) {
                                                var covered = {{ $covered }};
                                                var ticketModulateur = covered * percentage / 100;
                                                $('#ticket_moderateur').val(ticketModulateur.toFixed(2));
                                                updateTotalAmount();
                                            }

                                            function updateTotalAmount() {
                                                var ticketModulateur = parseFloat($('#ticket_moderateur').val()) || 0;
                                                var topUp = parseFloat($('#top_up').val()) || 0;
                                                var totalAmount = ticketModulateur + topUp;
                                                $('#total_amount').val(totalAmount.toFixed(2) + ' RWF');

                                                // Update hidden input field
                                                $('#updated_total_amount_input').val(totalAmount.toFixed(2));
                                            }

                                            $(document).ready(function() {
                                                // Event listener for insurance percentage change
                                                $('#insurance_percentage').change(function() {
                                                    var percentage = parseFloat($(this).val());
                                                    if (percentage > 0) {
                                                        calculateTicketModulateur(percentage);
                                                    } else {
                                                        $('#ticket_moderateur').val('0');
                                                        updateTotalAmount();
                                                    }
                                                });

                                                // Event listener for partial payment checkbox
                                                $('#pay_partial').change(function() {
                                                    $('#partial_field').toggle($(this).is(':checked'));
                                                });

                                                // Event listener for input changes
                                                $('#ticket_moderateur, #top_up').on('input', function() {
                                                    updateTotalAmount();
                                                });
                                            });
                                        </script>
                                        <label for="payment_method">PAYMENT METHOD </label><br><br>
                                        <div class="col-md-4">
                                            <div class="">
                                                <label><input type="checkbox" name="payment_method[]" value="1">
                                                    Momo</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="">
                                                <label><input type="checkbox" name="payment_method[]" value="2">
                                                    Cash</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="">
                                                <label><input type="checkbox" name="payment_method[]" value="3">
                                                    POS</label>
                                            </div>
                                        </div>
                                        <div class="row"><br>
                                            <div id="paymentInputs"></div>
                                        </div>
                                        <input type="hidden" name="paypos" id="paypos_input">
                                        <input type="hidden" name="paymomo" id="paymomo_input">
                                        <input type="hidden" name="paycash" id="paycash_input">

                                        <br>
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
                                                INSURANCE : {{ $formattedCovered }} <br><br>
                                                TOTOL AMOUNT: {{ $formattedTotalPrice }}<br>
                                                <!-- TOP UP AMOUNT: {{ $topUpAmount }} -->
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
            $("input[type='checkbox'][name='payment_method[]']").change(function() {
                // Clear existing input fields
                $("#paymentInputs").empty();
    
                $("input[type='checkbox'][name='payment_method[]']:checked").each(function() {
                    var value = $(this).val();
                    // Append input fields based on selected payment method
                    if (value === "1") {
                        $("#paymentInputs").append(
                            '<div class="col-lg-4"><input type="text" class="form-control momo-input" name="paymomo[]" placeholder="Momo"><button type="button" class="remove-input btn btn-danger"><i class="fa fa-times"></i></button></div>'
                        );
                    } else if (value === "2") {
                        $("#paymentInputs").append(
                            '<div class="col-lg-4"><input type="text" class="form-control cash-input" name="paycash[]" placeholder="Cash"><button type="button" class="remove-input btn btn-danger"><i class="fa fa-times"></i></button></div>'
                        );
                    } else if (value === "3") {
                        $("#paymentInputs").append(
                            '<div class="col-lg-4"><input type="text" class="form-control pos-input" name="paypos[]" placeholder="POS"><button type="button" class="remove-input btn btn-danger"><i class="fa fa-times"></i></button></div>'
                        );
                    }
                });
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
    
            $(document).on("input", ".pos-input", function() {
                $("#paypos_input").val($(this).val());
            });
        });
    </script>
    
    
    

@endsection
