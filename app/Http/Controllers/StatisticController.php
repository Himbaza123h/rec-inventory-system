<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatisticController extends Controller
{
    public function getSalesData(Request $request)
    {
        $timeframe = $request->input('timeframe');
        $data = $this->fetchSalesData($timeframe);
        return response()->json($data);
    }

    public function getLensSalesData(Request $request)
    {
        return $this->fetchSalesData($request, 2); // Pass product_id for lenses
    }

    public function getFrameSalesData(Request $request)
    {
        return $this->fetchSalesData($request, '!=', 2);
    }

    private function fetchSalesData(Request $request, $productId = null)
    {
        $timeframe = $request->input('timeframe');
        $sales = Sale::query();

        if ($productId !== null) {
            $sales->where('product_id', $productId);
        } elseif ($productId === '!=') {
            $sales->where('product_id', '!=', $productId);
        }

        if ($timeframe === 'daily') {
            $sales->selectRaw('DATE(created_at) as time, SUM(paypos + paymomo + paycash + IFNULL(insurance.covered, 0)) as total')
                ->groupBy('time');
            $labels = Sale::selectRaw('DATE(created_at) as date')->distinct()->get()->pluck('date')->toArray();
        } elseif ($timeframe === 'weekly') {
            $sales->selectRaw('WEEK(created_at) as time, SUM(paypos + paymomo + paycash + IFNULL(insurance.covered, 0)) as total')
                ->groupBy('time');
            $labels = Sale::selectRaw('WEEK(created_at) as week')->distinct()->get()->pluck('week')->toArray();
        } elseif ($timeframe === 'monthly') {
            $sales->selectRaw('MONTH(created_at) as time, SUM(paypos + paymomo + paycash + IFNULL(insurance.covered, 0)) as total')
                ->groupBy('time');
            $labels = Sale::selectRaw('MONTH(created_at) as month')->distinct()->get()->pluck('month')->toArray();
        }

        $salesData = $sales->get()->keyBy('time')->toArray();

        $dataset = [];
        foreach ($labels as $label) {
            $dataset[] = isset($salesData[$label]) ? $salesData[$label]['total'] : 0;
        }

        $datasets = [
            [
                'label' => 'Sales',
                'data' => $dataset,
                'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                'borderColor' => 'rgba(75, 192, 192, 1)',
                'borderWidth' => 1
            ]
        ];

        return compact('labels', 'datasets');
    }
}
