<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;

class SellController extends Controller
{
    public function index()
    {
        $sales = Sale::all();
        return view('seller.make-sales.index', compact('sales'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product' => 'required|string',
            'client' => 'required|string',
            'brand' => 'required|string',
            'item_code' => 'required|string',
            'price' => 'required|numeric',
            'qty' => 'required|integer',
            'color' => 'required|string',
            'customer_name' => 'required|string',
            'contact' => 'required|string',
            'vat' => 'required|string',
            'operation_notes' => 'nullable|string',
        ]);
        Sale::create($validatedData);
        return redirect()->back()->with('success', 'Sale record created successfully!');
    }

    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->delete();

        return redirect()->back()->with('success', 'Sale record deleted successfully!');
    }

    public function edit($id)
    {
        $sale = Sale::findOrFail($id);
        return view('seller.editsell', compact('sale'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'product' => 'required|string',
            'client' => 'required|string',
            'brand' => 'required|string',
            'item_code' => 'required|string',
            'price' => 'required|numeric',
            'discount' => 'required|numeric',
            'qty' => 'required|integer',
            'color' => 'required|string',
            'customer_name' => 'required|string',
            'contact' => 'required|string',
            'vat' => 'required|string',
            'operation_notes' => 'nullable|string',
        ]);
        $sale = Sale::findOrFail($id);
        $sale->update($validatedData);
        return redirect()->back()->with('success', 'Sale record updated successfully!');
    }
}
