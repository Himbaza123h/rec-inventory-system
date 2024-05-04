<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\CartItem;
use App\Models\Stock;
use App\Models\Sale;
use App\Models\CartLens;

class CartController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data = CartItem::select('sale_code', 'created_at')
            ->where('status', 1)
            ->where('user_id', $user->id)
            ->distinct()
            ->get();
        $data_array_2 = [];

        foreach ($data as $cartItem) {
            $amount = CartItem::where('sale_code', $cartItem->sale_code)
                ->where('user_id', $user->id)
                ->whereDate('created_at', $cartItem->created_at->toDateString())
                ->sum('amount');

            $data_array_2[$cartItem->sale_code] = $amount;
        }

        // Controlling Lens fields
        $sale_lens = CartLens::select('sale_lens_code', 'created_at')
            ->where('status', 1)
            ->where('user_id', $user->id)
            ->distinct()
            ->get();
        $lens_array = [];

        foreach ($sale_lens as $cartLensItem) {
            $amount = CartLens::where('sale_lens_code', $cartLensItem->sale_lens_code)
                ->where('user_id', $user->id)
                ->whereDate('created_at', $cartLensItem->created_at->toDateString())
                ->sum('amount');

            $lens_array[$cartLensItem->sale_lens_code] = $amount;
        }

        return view('seller.make-sales.index', compact('data', 'data_array_2', 'sale_lens', 'lens_array'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $Salecode = $request->input('salecode');
        $validator = Validator::make($request->all(), [
            'covered' => 'required|string',
            'insurance' => 'required|integer',
            'insurance_number' => 'required|string',
        ]);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        foreach ($request->selected as $itemId) {
            $qty = $request->input("qty_$itemId");
            $price = $request->input("price_$itemId");
            $total = $qty * $price;
            $date = date('Y-m-d');

            $stock = Stock::where('id', $itemId)->first();
            // Check if a record exists with the given item ID and status 1
            $existingSale = CartItem::where('item_id', $stock->item_id)
                ->where('user_id', $user->id)
                ->where('status', 1)
                ->first();

            if ($existingSale) {
                // If an existing record is found, update its quantity
                $existingSale->update([
                    'qty' => $qty,
                    'price' => $price,
                    'amount' => $total,
                ]);
            } else {
                $new = new CartItem();
                $new->item_id = $stock->item_id;
                $new->sale_code = $Salecode;
                $new->qty = $qty;
                $new->user_id = $user->id;
                $new->insurance = $request->insurance;
                $new->insurance_number = $request->insurance_number;
                $new->covered = $request->covered;
                $new->price = $price;
                $new->amount = $total;
                $new->created_at = $date;
                $new->save();
            }
        }
        return redirect()->back()->with('success', 'cart item successfully added!');
    }

    public function edit($id)
    {
        $data = CartItem::where('sale_code', $id)->get();

        return view('seller.glass.index', compact('data'));
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
            CartItem::where('sale_code', $id)
                ->where('user_id', $user->id)
                ->update([
                    'buyer_id' => $request->buyer_id,
                    'status' => 2,
                ]);

            // Update stock based on updated purchases
            $cartItems = CartItem::where('sale_code', $id)->get();

            foreach ($cartItems as $cartItem) {
                Sale::create([
                    'item_id' => $cartItem->item_id,
                    'buyer_id' => $request->buyer_id,
                    'cart_id' => $cartItem->id,
                    'seller_id' => $user->id,
                    'product_id' => 1,
                    'item_quantity' => $cartItem->qty,
                    'payment_method' => $request->payment_method,
                ]);

                $stock = Stock::where('item_id', $cartItem->item_id)->first();
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
    public function delete($id)
    {
        $user = Auth::user();
        try {
            CartItem::where('sale_code', $id)
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
