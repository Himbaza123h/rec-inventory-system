<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StockLens;
use App\Models\CartLens;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartLensController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        $salelenscode = $request->input('saleLenscode');
        foreach ($request->selected2 as $itemId) {
            $qty = $request->input("Qty_$itemId");
            $price = $request->input("price_$itemId");
            $total = $qty * $price;
            $date = date('Y-m-d');

            $stock = StockLens::where('id', $itemId)->first();
            $existingSale = CartLens::where('item_id', $stock->item_id)
                ->where('user_id', $user->id)
                ->where('status', 1)
                ->first();

            if ($existingSale) {
                $existingSale->update([
                    'qty' => $qty,
                    'price' => $price,
                    'amount' => $total,
                ]);
            } else {
                $new = new CartLens();
                $new->item_id = $stock->item_id;
                $new->sale_lens_code = $salelenscode;
                $new->qty = $qty;
                $new->user_id = $user->id;
                $new->price = $price;
                $new->amount = $total;
                $new->created_at = $date;
                $new->save();
            }
        }
        return redirect()->back()->with('success', 'item successfully added to cart!');
    }

    public function edit($id)
    {
        $lens = CartLens::where('sale_lens_code', $id)->get();

        return view('seller.lens.index', compact('lens'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        // Validate the form data
        $validator = Validator::make($request->all(), [
            'buyer_id' => 'required|integer',
            'payment_method' => 'required|string',
        ]);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        try {
            // Update all purchases with the specified purchase_code
            CartLens::where('sale_lens_code', $id)
                ->where('user_id', $user->id)
                ->update([
                    'buyer_id' => $request->buyer_id,
                    'status' => 2,
                ]);

            // Update stock based on updated purchases
            $cartItems = CartLens::where('sale_lens_code', $id)->get();

            foreach ($cartItems as $cartItem) {
                Sale::create([
                    'item_id' => $cartItem->item_id,
                    'buyer_id' => $request->buyer_id,
                    'cart_id' => $cartItem->id,
                    'product_id' => 2,
                    'seller_id' => $user->id,
                    'item_quantity' => $cartItem->qty,
                    'payment_method' => $request->payment_method,
                ]);
                $stock = StockLens::where('item_id', $cartItem->item_id)->first();
                if ($stock) {
                    $stock->item_quantity -= $cartItem->qty;
                    $stock->remaining -= $cartItem->qty;
                    $stock->gone = $cartItem->qty;
                    $stock->save();
                }
            }

            return redirect()->route('seller.sale.index')->with('success', 'Items sold successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function deleteCart($id)
    {
        $user = Auth::user();
        try {
            CartLens::where('sale_lens_code', $id)
                ->where('user_id', $user->id)
                ->delete();
            return redirect()->back()->with('success', 'sale removed from the list!');
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'msg' => $th->getMessage(),
            ]);
        }
    }
}
