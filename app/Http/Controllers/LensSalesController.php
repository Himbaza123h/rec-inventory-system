<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CartLens;
use Illuminate\Support\Facades\Validator;
use App\Models\Lens;
use App\Models\StockLens;
use App\Models\Sale;

class LensSalesController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $carts = CartLens::where('status', 1)
            ->where('user_id', $user->id)
            ->get();
        $lens = Lens::all();
        return view('seller.make-sales.lens.index', compact('lens', 'carts'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // Validate the incoming request data
        $validatedData = $request->validate([
            'quantity' => 'required|integer|min:1',
            'attribute_id' => 'required|integer',
            'category_id' => 'required|string',
            'power_id' => 'required|string',
        ]);

        // Retrieve the item based on the category_id
        $item = Lens::where('mark_lens', $request->category_id)
            ->where('lens_attribute', $request->attribute_id)
            ->where('lens_power', $request->power_id)
            ->first();
        if (!$item) {
            return redirect()->back()->with('error', 'Item does not exist in stock');
        }

        $stock = StockLens::where('item_id', $item->id)->first();

        // Check if the requested quantity exceeds available stock
        if ($stock->item_quantity < $request->quantity) {
            return redirect()->back()->with('error', 'Insufficient stock');
        }

        // Calculate the amount based on the selected item's price and the quantity entered
        $amount = $item->price * $validatedData['quantity'];

        // Check if the item already exists in the cart with status 1
        $existingCartItem = CartLens::where('item_id', $item->id)
            ->where('user_id', $user->id)
            ->where('status', 1)
            ->first();

        if ($existingCartItem) {
            try {
                // Update the quantity and amount of the existing cart item
                $existingCartItem->qty = $validatedData['quantity'];
                $existingCartItem->amount = $amount;
                $existingCartItem->save();

                // Return a redirect with success message
                return redirect()->back()->with('success', 'Cart updated with new quantity!');
            } catch (\Exception $e) {
                // Return a redirect with error message if an exception occurs
                return redirect()->back()->with('error', $e->getMessage());
            }
        }

        try {
            // Generate random number for the sale code
            $randomNumber = rand(100000, 999999);
            $randomSaleCode = 'SALE-INVOICE' . $randomNumber;

            // Create a new cart item with the validated data and generated sale code
            $cartItem = CartLens::create([
                'item_id' => $item->id,
                'qty' => $validatedData['quantity'],
                'user_id' => Auth::user()->id,
                'sale_lens_code' => $randomSaleCode,
                'price' => $item->price,
                'amount' => $amount,
            ]);

            // Return a redirect with success message
            return redirect()->back()->with('success', 'Item added to cart successfully!');
        } catch (\Exception $e) {
            // Return a redirect with error message if an exception occurs
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function checkout($id)
    {
        $user = Auth::user();
        $data = CartLens::where('user_id', $user->id)
            ->where('status', 1)
            ->get();
        return view('seller.make-sales.lens.edit', compact('data'));
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
            $cartItems = CartLens::where('user_id', $user->id)
                ->where('status', 1)
                ->get();

            foreach ($cartItems as $cartItem) {
                Sale::create([
                    'item_id' => $cartItem->item_id,
                    'buyer_id' => $request->buyer_id,
                    'cart_id' => $cartItem->id,
                    'seller_id' => $user->id,
                    'product_id' => 2,
                    'item_quantity' => $cartItem->qty,
                    'payment_method' => $request->payment_method,
                ]);
                CartLens::where('user_id', $user->id)
                    ->where('status', 1)
                    ->update([
                        'buyer_id' => $request->buyer_id,
                        'status' => 2,
                    ]);

                $stock = StockLens::where('item_id', $cartItem->item_id)->first();
                if ($stock) {
                    $stock->item_quantity -= $cartItem->qty;
                    $stock->remaining -= $cartItem->qty;
                    $stock->gone = $cartItem->qty;
                    $stock->save();
                }
            }

            // return redirect()->route('seller.lens.sales.index')->with('success', 'Items sold successfully!');
            return redirect()->route('seller.invoice.index')->with('success', 'Items sold successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function remove($id)
    {
        $user = Auth::user();
        try {
            $data = CartLens::where('item_id', $id)
                ->where('user_id', $user->id)
                ->first();
            $data->delete();
            return redirect()->back()->with('success', 'item removed on cart!');
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'msg' => $th->getMessage(),
            ]);
        }
    }

    public function performa($id)
    {
        $cartItems = CartLens::where('sale_lens_code', $id)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'No cart items found for the specified sale code!');
        }
        foreach ($cartItems as $cartItem) {
            $cartItem->update([
                'status' => 3,
            ]);
        }

        return redirect()->back()->with('success', 'Updated all cart items to performa successfully!');
    }
}
