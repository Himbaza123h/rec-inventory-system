<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use Illuminate\Support\Facades\DB;

class WeeklyReportController extends Controller
{
    public function show()
    {
        // Fetch weekly sales data
        $salesData = CartItem::where('status', 2)
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->orderBy('created_at')
            ->get()
            ->groupBy(function($item) {
                return $item->created_at->format('l'); // Group by day of the week
            })
            ->map(function($items) {
                return $items->sum('amount'); // Sum up the amount for each day
            });

        // Initialize arrays for labels and data
        $labels = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $salesChartData = array_fill(0, 7, 0); 

        // Fill the data array with sales amounts
        foreach ($salesData as $day => $amount) {
            $index = array_search($day, $labels);
            if ($index !== false) {
                $salesChartData[$index] = $amount;
            }
        }

        // Pass the data to the view
        return view('weekly_report', [
            'labels' => $labels,
            'salesChartData' => $salesChartData,
        ]);
    }
}
