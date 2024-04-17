<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;

class StockController extends Controller
{
    public function index()
    {
        $data = Stock::all();
        return view('admin.stock.index', compact('data'));
    }
}
