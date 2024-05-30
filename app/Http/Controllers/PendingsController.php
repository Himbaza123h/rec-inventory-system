<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Insurance;
use Illuminate\Http\Request;
use App\Models\Pending;
use App\Models\Sale;
use Illuminate\Support\Facades\Validator;

class PendingsController extends Controller
{
    public function index()
    {
        $groupedPendings = Pending::get()->groupBy('cart_id');

        // Calculate total amount for each order number
        $data = [];
        foreach ($groupedPendings as $orderNumber => $pendings) {
            $totalAmount = $pendings->sum('amount');
            $orderInfo = $pendings->first();
            $customer = Customer::find($orderInfo->buyer_id);
            $insurance = Insurance::find($orderInfo->insurance_id);
            $orderDate = $orderInfo->created_at->format('Y-m-d');
            $orderStatus = $orderInfo->status;
            $orderPrefix = $orderInfo->prefix;
            $covered = $orderInfo->covered;
            $product = $orderInfo->product_id;
            $data[] = [
                'order_number' => $orderNumber,
                'total_amount' => $totalAmount,
                'items' => $pendings,
                'customer' => $customer,
                'insurance' => $insurance,
                'order_date' => $orderDate,
                'status' => $orderStatus,
                'prefix' => $orderPrefix,
                'product' =>$product,
                'covered' =>$covered,
                
            ];
        }
        return view('seller.make-sales.pendings.index', compact('data'));
    }

    public function edit($id)
    {
        $orders = Pending::where('cart_id', $id)->get();
        return view('seller.make-sales.pendings.edit', compact('orders'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hidden_item_id' => 'required',
            'insurance_percentage' => 'nullable',
            'paymomo' => 'nullable',
            'paycash' => 'nullable',
            'paypos' => 'nullable',
            'insurance_id' => 'nullable',
            'covered_hidden' => 'nullable',
        ]);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        $ticketModelateur = ($request->covered_hidden * $request->insurance_percentage) / 100;

        $orders = Pending::where('item_id', $request->hidden_item_id)->get();
        try {
            $sale = new Sale();
            foreach ($orders as $value) {
                $sale->item_id = $request->hidden_item_id;
                $sale->cart_id = $value->cart_id;
                $sale->product_id = $value->product_id;
                $sale->item_quantity = $value->item_quantity;
                $sale->buyer_id = $value->buyer_id;
                $sale->seller_id = $value->seller_id;
                $sale->paymomo = $request->paymomo ?? null;
                $sale->paycash = $request->paycash ?? null;
                $sale->paypos = $request->paypos ?? null;
                $sale->insurance_id = $value->insurance_id;
                $sale->covered = $value->covered;
                $sale->ticket_modérateur = $ticketModelateur;
                $sale->save();
            }
            return redirect()->route('seller.make.sales.index')->with('success', 'Sale created successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
