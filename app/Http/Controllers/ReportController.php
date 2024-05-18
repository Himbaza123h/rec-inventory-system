<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\Sale;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Item;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->role == 'admin') {
            $query = Sale::query();

            // Filter by date range if provided
            if ($request->has('fromDate') && $request->has('toDate')) {
                $fromDate = $request->input('fromDate');
                $toDate = $request->input('toDate');
                $query->whereBetween('created_at', [$fromDate, $toDate]);
            }

            $sales = $query->get();
        } else {
            // Get daily sales for other users
            $sales = Sale::whereDate('created_at', now()->toDateString())->get();
        }

        // Paginate the sales data manually
        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $salesCollection = collect($sales);
        $currentPageItems = $salesCollection->slice(($page - 1) * $perPage, $perPage)->all();
        $sales = new LengthAwarePaginator($currentPageItems, count($salesCollection), $perPage);
        $routeName = auth()->user()->role . '.reports.index';
        $sales->setPath(route($routeName));
        return view('reports.general.glass.index', compact('sales'));
    }

    public function index2()
    {
        $user = Auth::user();
        if ($user->role == 'admin') {
            $sales = Sale::where('product_id', 2)->get();
        } else {
            $sales = Sale::where('product_id', 2)
                ->where('seller_id', $user->id)
                ->get();
        }

        // Paginate the sales data manually
        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $salesCollection = collect($sales);
        $currentPageItems = $salesCollection->slice(($page - 1) * $perPage, $perPage)->all();
        $sales = new LengthAwarePaginator($currentPageItems, count($salesCollection), $perPage);
        $routeName = auth()->user()->role . '.reports.lens.index';
        $sales->setPath(route($routeName));

        return view('reports.general.lens.index', compact('sales'));
    }

    public function fastslow()
    {
        $startDate = now()->subMonth();
        $endDate = now();
        $items = Item::select('items.*', DB::raw('COUNT(sales.id) as sale_count'))
            ->leftJoin('sales', 'items.id', '=', 'sales.item_id')
            ->whereBetween('sales.created_at', [$startDate, $endDate])
            ->groupBy('items.id')
            ->orderByDesc('sale_count') // Sort by sale count in descending order
            ->get();

        return view('reports.fast-slow.index', compact('items'));
    }
}
