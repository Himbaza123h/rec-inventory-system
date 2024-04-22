<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use Illuminate\Support\Facades\Response;

class InvoiceController extends Controller
{
    public function index()
    {
        $sales = Sale::all();
        
        return view('seller.invoice', compact('sales'));
    }

    public function view($id)
    {
        
        $sale = Sale::findOrFail($id);
        if ($sale->vat === 'Include') {
            $vatAmount = $sale->total * 0.18; 
            $grandTotal = $sale->total + $vatAmount;
        } else {
            $grandTotal = $sale->total;
        }
        return view('seller.iteminvoice', compact('sale', 'grandTotal'));
    }

}
