<?php

namespace App\Http\Controllers;

use App\Models\StockLens;
use Illuminate\Http\Request;
use App\Models\Stock;

class StockController extends Controller
{
    public function index()
    {
        $data = Stock::all();
        $data2 = StockLens::all();
        return view('admin.stock.index', compact('data', 'data2'));
    }
}
