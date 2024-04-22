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
                        <h4 class="pull-left page-title">LENS REPORT</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-2">
                                        FROM
                                        <div class="input-group">
                                            <input type="date" id="fromDate" class="form-control input-sm">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        TO
                                        <div class="input-group">
                                            <input type="date" id="toDate" class="form-control input-sm">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <br>
                                        <button class="btn btn-primary" onclick="filtering()">Filter</button>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div id="userReport" class="inbox-widget nicescroll mx-box">
                                    <table id="datatable-buttons" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>N/O</th>
                                                <th>Category</th>
                                                <th>Attribute</th>
                                                <th>Lens Power</th>
                                                <th>Quantity</th>
                                                @if (Auth::user()->role == 'admin')
                                                    <th>Seller</th>
                                                @endif
                                                <th>Unity Price</th>
                                                <th>Total</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sales as $index => $item)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $item['lens']['category']['category_name'] }}</td>
                                                    <td>{{ $item['lens']['lens_attribute'] }}</td>
                                                    <td>{{ $item['lens']['lens_power'] }}</td>
                                                    <td>{{ $item['item_quantity'] }}</td>
                                                    @if (Auth::user()->role == 'admin')
                                                        <td>{{ $item?->user?->name }}</td>
                                                    @endif
                                                    <td>{{ $item['lens']['price'] }} RWF</td>
                                                    <td>{{ $item['item_quantity'] * $item['lens']['price'] }} RWF</td>
                                                    <td>{{ $item['created_at'] }}</td>
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
        function filtering() {
            var storeId = $('#storeId').val();
            var fromDate = $('#fromDate').val();
            var toDate = $('#toDate').val();

            $('#datatable-buttons tbody tr').each(function() {
                var category = $(this).find('td:nth-child(2)').text().trim();
                var date = $(this).find('td:last-child').text().trim();

                // Check if the product category matches the selected option or if "Select Product" is chosen
                var productMatches = (storeId === 'Select Product' || category.toLowerCase() === storeId);


                // Check if the date falls within the specified range, but only if both the start and end dates are provided
                var dateInRange = (!fromDate || !toDate || (date >= fromDate && date <= toDate));

                // Show or hide the row based on the conditions
                if (productMatches && dateInRange) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
    </script>
@endsection
