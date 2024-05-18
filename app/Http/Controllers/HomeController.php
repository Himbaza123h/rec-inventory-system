<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->approved == 1) {
            // Get today's date
            $today = now()->format('Y-m-d');

            // Retrieve sales data for today
            $sales = Sale::whereDate('created_at', $today)->get();

            // Initialize arrays to store data for frames and lenses
            $framesData = [];
            $lensData = [];

            // Group sales by cart_id and sum payment amounts
            $salesGrouped = $sales->groupBy('cart_id')->map(function ($group) {
                return $group->sum('paycash') + $group->sum('paypos') + $group->sum('paymomo');
            });

            // Get hours labels for the x-axis
            $hoursLabels = [];
            for ($i = 8; $i <= 20; $i += 1) {
                $hoursLabels[] = $i . 'am';
            }

            // Initialize arrays to store summed payment amounts for each hour
            $framesHourlyData = array_fill(0, count($hoursLabels), 0);
            $lensHourlyData = array_fill(0, count($hoursLabels), 0);

            // Populate data arrays with summed payment amounts for each hour
            foreach ($sales as $sale) {
                $hour = date('H', strtotime($sale->created_at)) - 8; // Calculate hour index (8am = 0, 10am = 1, ...)
                $paymentSum = $salesGrouped[$sale->cart_id] ?? 0;

                if ($sale->product_id == 2) {
                    $lensHourlyData[$hour] += $paymentSum;
                } else {
                    $framesHourlyData[$hour] += $paymentSum;
                }
            }

            // Prepare data for charts
            $framesData = $framesHourlyData;
            $lensData = $lensHourlyData;

            if (Auth::user()->role == 'admin') {
                return view('admin.index', compact('framesData', 'lensData', 'hoursLabels'));
            } else {
                return view('seller.index', compact('framesData', 'lensData', 'hoursLabels'));
            }
        }
    }

    public function filterData(Request $request)
    {
        $date = $request->input('date');
        $sales = Sale::whereDate('created_at', $date)->get();

        $framesData = [];
        $lensData = [];

        $salesGrouped = $sales->groupBy('cart_id')->map(function ($group) {
            return $group->sum('paycash') + $group->sum('paypos') + $group->sum('paymomo');
        });

        $hoursLabels = [];
        for ($i = 8; $i <= 20; $i += 1) {
            $hoursLabels[] = $i . 'am';
        }

        $framesHourlyData = array_fill(0, count($hoursLabels), 0);
        $lensHourlyData = array_fill(0, count($hoursLabels), 0);

        foreach ($sales as $sale) {
            $hour = date('H', strtotime($sale->created_at)) - 8;
            $paymentSum = $salesGrouped[$sale->cart_id] ?? 0;

            if ($sale->product_id == 2) {
                $lensHourlyData[$hour] += $paymentSum;
            } else {
                $framesHourlyData[$hour] += $paymentSum;
            }
        }

        return response()->json([
            'framesData' => $framesHourlyData,
            'lensData' => $lensHourlyData,
            'hoursLabels' => $hoursLabels,
        ]);
    }

    
}
