<?php

namespace App\Http\Controllers;

use App\Models\StockLens;
use Illuminate\Http\Request;
use App\Models\Stock;

class StockController extends Controller
{
    public function index()
    {
        $data = Stock::where('status', true)
        ->where('product_id', 1)
        ->get();
        $data3 = Stock::where('status', true)
        ->where('product_id', 3)
        ->get();
        $data4 = Stock::where('status', true)
        ->where('product_id', 4)
        ->get();
        $data2 = StockLens::all();
        return view('admin.stock.index', compact('data','data3','data4', 'data2'));
    }
}
