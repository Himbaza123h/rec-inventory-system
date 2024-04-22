<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use App\Models\Purchase;
use Vtiful\Kernel\Format;
use App\Models\Stock;
use App\Models\PurchaseLens;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends Controller
{
    public function index()
    {
        $data = Purchase::select('purchase_code', 'created_at')->where('status', 1)->distinct()->get();
        $data_array_2 = [];

        foreach ($data as $purchase) {
            $amount = Purchase::where('purchase_code', $purchase->purchase_code)
                ->whereDate('created_at', $purchase->created_at->toDateString())
                ->sum('amount');

            $data_array_2[$purchase->purchase_code] = $amount;
        }

        // Fetch data for lenses
        $lens2 = PurchaseLens::select('purchase_code', 'created_at')->where('status', 1)->distinct()->get();
        $data_array_1 = [];

        foreach ($lens2 as $purchase) {
            $amount = PurchaseLens::where('purchase_code', $purchase->purchase_code)
                ->whereDate('created_at', $purchase->created_at->toDateString())
                ->sum('amount');

            $data_array_1[$purchase->purchase_code] = $amount;
        }

        return view('purchase.index', compact('data', 'data_array_2', 'lens2', 'data_array_1'));
    }

    public function edit($id)
    {
        $data = Purchase::where('purchase_code', $id)->get();

        return view('purchase.edit', compact('data'));
    }
    public function store(Request $request)
    {
        $Pcode = $request->input('purchaseCode');
        foreach ($request->selected as $itemId) {
            $quantity = $request->input("Qty_$itemId");
            $price = $request->input("price_$itemId");
            $total = $quantity * $price;
            $date = date('Y-m-d');

            // Check if a record exists with the given item ID and status 1
            $existingPurchase = Purchase::where('item_id', $itemId)->where('status', 1)->first();

            if ($existingPurchase) {
                // If an existing record is found, update its quantity
                $existingPurchase->update([
                    'qty' => $quantity,
                    'price' => $price,
                    'amount' => $total,
                ]);
            } else {
                // If no existing record is found, create a new one
                $new = new Purchase();
                $new->item_id = $itemId;
                $new->purchase_code = $Pcode;
                $new->qty = $quantity;
                $new->price = $price;
                $new->amount = $total;
                $new->created_at = $date;
                $new->save();
            }
        }
        return redirect()->back()->with('success', 'Purchase cart successfully added!');
    }

    public function update(Request $request, $id)
    {
        // Validate the form data
        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required|integer',
            'payment_method' => 'required|string',
        ]);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        } else {
            try {
                // Update all purchases with the specified purchase_code
                Purchase::where('purchase_code', $id)->update([
                    'supplier' => $request->supplier_id,
                    'payment_method' => $request->payment_method,
                    'status' => 2,
                ]);

                // Update or create Stock based on updated purchases
                $purchases = Purchase::where('purchase_code', $id)->get();
                foreach ($purchases as $purchase) {
                    $stock = Stock::where('item_id', $purchase->item_id)->first();
                    if ($stock) {
                        // Update existing stock
                        $stock->item_quantity += $purchase->qty;
                        $stock->remaining += $purchase->qty;
                        $stock->save();
                    } else {
                        // Create new stock
                        Stock::create([
                            'item_id' => $purchase->item_id,
                            'purchase_id' => $purchase->id,
                            'item_quantity' => $purchase->qty,
                            'gone' => 0,
                            'remaining' => $purchase->qty,
                        ]);
                    }
                }

                return redirect()->route('admin.purchase.index')->with('success', 'Purchases and Stock successfully updated!');
            } catch (\Throwable $th) {
                return redirect()->back()->with('error', $th->getMessage());
            }
        }
    }

    public function delete($id)
    {
        try {
            Purchase::where('purchase_code', $id)->delete();
            return redirect()->back()->with('success', 'Purchase removed from the list!');
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'msg' => $th->getMessage(),
            ]);
        }
    }

    public function deleteItem($id)
    {
        try {
            Purchase::where('item_id', $id)->delete();
            return redirect()->back()->with('success', 'removed from the list!');
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'msg' => $th->getMessage(),
            ]);
        }
    }
}
