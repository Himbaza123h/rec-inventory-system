@extends('layouts.app')

@section('page-title')
    {{ __('Proceed Order') }}
@endsection



@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">

                <!-- Page-Title -->


                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="pull-left page-title"><b> ORDER</b><i class="ion-ios7-cart-outline"></i></h3>
                        <ol class="breadcrumb pull-right">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route('seller.make.order') }}">Order</a></li>
                            <li class="active">Details</li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <!-- USER LIST -->
                    <div class="col-lg-4 hidden-print">
                        <div class="panel panel-inverse" style="height: 700px">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="panel-title" style="color: #fff;">CONFIRM CHECKOUT</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div id="userResurts" class="inbox-widget nicescroll mx-box">
                                    @if (!$orders->isEmpty())
                                        <form action="{{ route('seller.place.order', ['id' => $orders[0]->order_code]) }}"
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

                                            @php
                                                $totalPrice = 0;
                                                $covered = 0;
                                                foreach ($orders as $item) {
                                                    $totalPrice += $item->amount;
                                                    $covered += $item->amount_covered;
                                                }
                                                $toUp = $totalPrice - $covered;
                                            @endphp

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
                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <input type="checkbox" name="partial_to_pay" id="pay_partial"
                                                        style="width: 20px; height: 20px;">
                                                    <label for="pay_partial">PARTIAL</label>
                                                </div>

                                                <input type="hidden" name="full_to_pay" value="{{ $toUp }}"
                                                    style="display:none">
                                                <div class="col-md-4">
                                                    <input type="checkbox" id="pay_full" style="width: 20px; height: 20px;"
                                                        checked>
                                                    <label for="pay_full">PAY FULL</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="checkbox" id="pay_none"
                                                        style="width: 20px; height: 20px;">
                                                    <label for="pay_none">Not Paid</label>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="row" id="partial_field" style="display: none;">
                                                <label for="partial_amount">Enter Partial Amount</label>
                                                <input type="text" class="form-control" id="partial_amount"
                                                    placeholder="Partial Amount (RWF)">
                                            </div>

                                            <div class="row" id="total_amount_field">
                                                <label for="total_amount">Total Amount to Pay</label>
                                                <input type="text" class="form-control" id="total_amount"
                                                    name="total_amount"
                                                    value="{{ number_format($toUp, 0, '.', ',') }} RWF" disabled>
                                            </div>
                                            <script>
                                                // Function to calculate ticket modérateur and update UI
                                                function calculateTicketModulateur(percentage) {
                                                    var covered = {{ $covered }};
                                                    var ticketModulateur = covered * percentage / 100;
                                                    $('#ticket_moderateur').val(ticketModulateur.toFixed(2));
                                                    updateTotalAmount();
                                                }

                                                // Function to update total amount based on ticket modérateur and top up
                                                function updateTotalAmount() {
                                                    var ticketModulateur = parseFloat($('#ticket_moderateur').val()) || 0;
                                                    var topUp = parseFloat($('#top_up').val()) || 0;
                                                    var totalAmount = ticketModulateur + topUp;
                                                    $('#total_amount').val(totalAmount.toFixed(2) + ' RWF');
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
                                            <input type="hidden" id="top_up_hidden" name="top_up_hidden"
                                                value="{{ $toUp }}">
                                            <input type="hidden" id="covered_hidden" name="covered_hidden"
                                                value="{{ $covered }}">


                                            <br>
                                            <div class="col-md-12" id="payment_input">


                                                <label for="payment_method">PAYMENT METHOD </label><br>
                                                <div class="col-md-4">
                                                    <div class="checkbox">
                                                        <label><input type="checkbox" name="payment_method[]"
                                                                value="1">
                                                            Momo</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="checkbox">
                                                        <label><input type="checkbox" name="payment_method[]"
                                                                value="2">
                                                            Cash</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="checkbox">
                                                        <label><input type="checkbox" name="payment_method[]"
                                                                value="3">
                                                            POS</label>
                                                    </div>
                                                </div>
                                                <div class="row"><br>
                                                    <div id="paymentInputs"></div>
                                                </div>
                                                <input type="hidden" name="paypos" id="paypos_input">
                                                <input type="hidden" name="paymomo" id="paymomo_input">
                                                <input type="hidden" name="paycash" id="paycash_input">
                                            </div>
                                            <button type="submit" class="btn btn-success waves-effect waves-light"
                                                style="margin-top: 10px" id="purchase_item">CONFIRM <i
                                                    class="ion-ios7-cart-outline"></i></button>
                                        </form>
                                    @endif

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
                                                        {{ $orders[0]->sale_code }}</strong><br>
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
                                        <th colspan="4" class="text-center">ITEM INFO</th>
                                        <th>QUANTITY</th>
                                        <th>PRICE</th>
                                    </tr>
                                    <tbody>
                                        @php
                                            $totalPrice = 0;
                                            $covered = 0;
                                        @endphp
                                        @foreach ($orders as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>

                                                <td>{{ $item->item?->category?->category_name }}</td>
                                                <td>{{ $item->item->attribute?->attribute_name }}</td>
                                                <td>{{ $item->item?->power_sph }}-{{ $item->item?->power_cyl }}-{{ $item->item?->power_axis }}-{{ $item->item?->power_add }}
                                                </td>
                                                <td>{{ $item->item?->type?->type_name }}</td>

                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ number_format($item->amount / $item->quantity, 0, '.', ',') }}RWF
                                                </td>
                                                <td class="covered" style="display: none;">{{ $item->covered }}</td>
                                            </tr>
                                            @php
                                                $totalPrice += $item->amount;
                                                $covered += $item->amount_covered;
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
                                                INSURANCE : {{ $formattedCovered }} <br>
                                                TOTOL AMOUNT: {{ $formattedTotalPrice }}<br>
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
            $("input[type='checkbox'][name='payment_method[]']").change(function() {
                // Clear existing input fields
                $("#paymentInputs").empty();

                $("input[type='checkbox'][name='payment_method[]']:checked").each(function() {
                    var value = $(this).val();
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




    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const payPartialCheckbox = document.getElementById('pay_partial');
            const payFullCheckbox = document.getElementById('pay_full');
            const partialField = document.getElementById('partial_field');
            const totalAmountField = document.getElementById('total_amount_field');
            const partialAmountInput = document.getElementById('partial_amount');
            const None = document.getElementById('pay_none');
            const payments = document.getElementById('payment_input');

            payPartialCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    partialField.style.display = 'block';
                    totalAmountField.style.display = 'none';
                    payFullCheckbox.checked = false; // Uncheck "PAY FULL"
                    None.checked = false;
                } else {
                    partialField.style.display = 'none';
                    totalAmountField.style.display = 'block';
                }
            });

            payFullCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    partialField.style.display = 'none';
                    totalAmountField.style.display = 'block';
                    payPartialCheckbox.checked = false; // Uncheck "PAY PARTIAL"
                    None.checked = false;
                } else {
                    totalAmountField.style.display = 'none';
                }
            });
            None.addEventListener('change', function() {
                if (this.checked) {
                    partialField.style.display = 'none';
                    payPartialCheckbox.checked = false; // Uncheck "PAY PARTIAL"
                    payFullCheckbox.checked = false; // Uncheck "PAY FULL"
                    totalAmountField.style.display = 'none';
                    payments.style.display = 'none';

                } else {
                    payments.style.display = 'block';
                    totalAmountField.style.display = 'block';
                }
            })

            // Prevent both checkboxes from being checked at the same time
            payPartialCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    payFullCheckbox.checked = false;
                }
            });

            payFullCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    payPartialCheckbox.checked = false;
                }
            });
        });
    </script>
@endsection
