<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseLens;
use App\Models\StockLens;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PurchaseLensController extends Controller
{
    public function edit($id)
    {
        $data = PurchaseLens::where('purchase_code', $id)->where('status', 1)->get();

        return view('purchase.lens.edit', compact('data'));
    }
    public function store(Request $request)
    {
        $Pcode = $request->input('purchaseCode');
        $productId = $request->input('product_id');
        Session::put('product_id', $productId);
        foreach ($request->selected as $dataId) {
            $quantity = $request->input("Qty2_$dataId");
            $price = $request->input("price2_$dataId");
            $total = $quantity * $price;
            $date = date('Y-m-d');

            // Check if a record exists with the given item ID and status 1
            $existingPurchase = PurchaseLens::where('item_id', $dataId)->where('status', 1)->first();

            if ($existingPurchase) {
                // If an existing record is found, update its quantity
                $existingPurchase->update([
                    'qty' => $quantity,
                    'price' => $price,
                    'amount' => $total,
                ]);
            } else {
                // If no existing record is found, create a new one
                $new = new PurchaseLens();
                $new->item_id = $dataId;
                $new->purchase_code = $Pcode;
                $new->qty = $quantity;
                $new->product_id = $productId;
                $new->price = $price;
                $new->amount = $total;
                $new->created_at = $date;
                $new->save();
            }
        }

        // Redirect to the edit route with the created purchase code
        return redirect()
            ->route('admin.purchase.lens.edit', [$Pcode])
            ->with('success', 'Purchase cart successfully added!');
    }

    public function update(Request $request, $id)
    {
        $productId = Session::get('product_id');
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
                PurchaseLens::where('purchase_code', $id)->update([
                    'supplier' => $request->supplier_id,
                    'payment_method' => $request->payment_method,
                    'status' => 2,
                ]);

                // Update or create Stock based on updated purchases
                $purchases = PurchaseLens::where('purchase_code', $id)->get();
                foreach ($purchases as $purchase) {
                    $stock = StockLens::where('item_id', $purchase->item_id)->first();
                    if ($stock) {
                        // Update existing stock
                        $stock->item_quantity += $purchase->qty;
                        $stock->remaining += $purchase->qty;
                        $stock->save();
                    } else {
                        // Create new stock
                        StockLens::create([
                            'item_id' => $purchase->item_id,
                            'purchase_id' => $purchase->id,
                            'item_quantity' => $purchase->qty,
                            'product_id' => $productId,
                            'gone' => 0,
                            'remaining' => $purchase->qty,
                        ]);
                    }
                }

                return redirect()->route('admin.stock.index')->with('success', 'Purchases and Stock successfully updated!');
            } catch (\Throwable $th) {
                return redirect()->back()->with('error', $th->getMessage());
            }
        }
    }

    public function delete($id)
    {
        try {
            PurchaseLens::where('purchase_code', $id)->delete();
            return redirect()->back()->with('success', 'Purchase removed from the list!');
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'msg' => $th->getMessage(),
            ]);
        }
    }

    public function deleteLens($id)
    {
        try {
            PurchaseLens::where('item_id', $id)->delete();
            return redirect()->back()->with('success', 'removed from the list!');
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'msg' => $th->getMessage(),
            ]);
        }
    }
}
