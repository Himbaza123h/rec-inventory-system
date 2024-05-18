<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        @if (auth()->user()->role == 'admin')
            {{ __('Sale Reports') }}
        @else
            {{ __('Daily Report') }}
        @endif
    </title>
</head>

<body>
    <center>
        <h2 style="font-family: 'Roboto Slab', serif;">
            @if (auth()->user()->role == 'admin')
                {{ __('Sales Report') }}
            @else
                {{ __('Daily Report') }}
            @endif
        </h2>
    </center>
    <table id="datatable-buttons" class="table table-striped table-bordered" border="1"
        style="border-collapse: collapse;">
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
                <th>DATE</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $index => $item)
                <tr data-product-id="{{ $item->product_id }}" data-insurance-id="{{ $item->insurance_id }}">
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
                    <td>{{ date('Y-m-d', strtotime($item['created_at'])) }}</td>
                </tr>
            @endforeach

        </tbody>
    </table>
</body>

</html>
