@extends('layouts.app')

@section('page-title')
    {{ __('Proceed Pending Order') }}
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
                        <div class="panel panel-inverse" style="height: 430px">
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
                                        <form action="{{ route('seller.confirm.pendings') }}" method="POST">
                                            @csrf


                                            @php
                                                $totalPrice = 0;
                                                $covered = 0;
                                                foreach ($orders as $item) {
                                                    $totalPrice += $item->amount;
                                                    $covered += $item->covered;
                                                }
                                                $toUp = $totalPrice - $covered;

                                            @endphp



                                            <input type="hidden" name="hidden_item_id" value="{{ $item->item_id }}">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="insurance_percentage">Insurance (%)</label><br>
                                                    <select id="insurance_percentage" name="insurance_percentage"
                                                        class="select2 form-control">
                                                        <option value="0">Select</option>
                                                        @for ($i = 5; $i <= 50; $i += 5)
                                                            <option value="{{ $i }}">{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div><br>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="ticket_moderateur">Ticket Modérateur</label><br>
                                                    <input type="text" id="ticket_moderateur" class="form-control"
                                                        placeholder="0" disabled />
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="top_up">TopUp</label><br>
                                                    <input type="text" id="top_up" class="form-control"
                                                        placeholder="{{ $toUp }}" disabled />
                                                </div>
                                            </div><br>

                                            <script>
                                                $(document).ready(function() {
                                                    $('#insurance_percentage').change(function() {
                                                        var percentage = parseFloat($(this).val());
                                                        if (percentage > 0) {
                                                            calculateTicketModulateur(percentage);
                                                        } else {
                                                            $('#ticket_moderateur').val('0');
                                                            updateTotalAmount();
                                                        }
                                                    });

                                                    function calculateTicketModulateur(percentage) {
                                                        var ticketModulateur = {{ $covered }} * percentage / 100;
                                                        $('#ticket_moderateur').val(ticketModulateur.toFixed(2));
                                                        updateTotalAmount();
                                                    }

                                                    function updateTotalAmount() {
                                                        var ticketModulateur = parseFloat($('#ticket_moderateur').val()) || 0;
                                                        var topUp = parseFloat($('#top_up').val()) || 0;
                                                        var totalAmount = ticketModulateur + topUp;
                                                        $('#amount_to_pay').val(totalAmount.toFixed(2));
                                                    }
                                                });
                                            </script>

                                            <input type="hidden" id="top_up_hidden" name="top_up_hidden"
                                                value="{{ $toUp }}">
                                            <input type="hidden" id="covered_hidden" name="covered_hidden"
                                                value="{{ $covered }}">
                                            <br>
                                            <div class="col-md-12">


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
                                                @if ($item->product_id == 2)
                                                    <td>{{ $item->item?->category?->category_name }}</td>
                                                    <td>{{ $item->item->attribute?->attribute_name }}</td>
                                                    <td>{{ $item->item?->power_sph }}-{{ $item->item?->power_cyl }}-{{ $item->item?->power_axis }}-{{ $item->item?->power_add }}
                                                    </td>
                                                    <td>{{ $item->item?->type?->type_name }}</td>
                                                @else
                                                    <td>{{ $item->item?->category?->category_name }}</td>
                                                    <td>{{ $item->item->color?->color_name }}</td>
                                                    <td>{{ $item->item?->code_id }}
                                                    </td>
                                                    <td>{{ $item->item?->type?->type_name }}</td>
                                                @endif

                                                <td>{{ $item->item_quantity }}</td>
                                                <td>{{ number_format($item->amount / $item->item_quantity, 0, '.', ',') }}RWF
                                                </td>
                                                <td class="covered" style="display: none;">{{ $item->covered }}</td>
                                            </tr>
                                            @php
                                                $totalPrice += $item->amount;
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

            payPartialCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    partialField.style.display = 'block';
                    totalAmountField.style.display = 'none';
                    payFullCheckbox.checked = false; // Uncheck "PAY FULL"
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
                } else {
                    totalAmountField.style.display = 'none';
                }
            });

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
