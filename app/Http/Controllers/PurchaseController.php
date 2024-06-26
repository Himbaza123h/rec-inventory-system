<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use App\Models\Purchase;
use Vtiful\Kernel\Format;
use App\Models\Stock;
use App\Models\CartItem;
use App\Models\PurchaseLens;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\PurchaseCart;

class PurchaseController extends Controller
{
    public function edit($id)
    {
        $data = Purchase::where('purchase_code', $id)->get();

        return view('purchase.edit', compact('data'));
    }
    public function store(Request $request)
    {
        $Pcode = $request->input('purchaseCode');
        $productId = $request->input('product_id');

        Session::put('product_id', $productId);
        foreach ($request->selected as $itemId) {
            $quantity = $request->input("Qty_$itemId");
            $price = $request->input("price_$itemId");
            $total = $quantity * $price;
            $date = date('Y-m-d');

            // Check if a record exists with the given item ID and status 1
            $existingPurchase = Purchase::where('item_id', $itemId)->where('product_id', $productId)->where('status', 1)->first();

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
                $new->product_id = $productId;
                $new->amount = $total;
                $new->created_at = $date;
                $new->save();
            }
        }

        // Redirect to the edit route with the created purchase code
        return redirect()
            ->route('admin.purchase.edit', [$Pcode])
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

    public function requestNew(Request $request)
    {
        $user = Auth::user();
        $carts = PurchaseCart::where('status', 1)
            ->where('uwabikoze', $user->id)
            ->get();

        $number = $request->query('number', 0);
        return view('purchase.new-item.index', compact('carts', 'number'));
    }
}
