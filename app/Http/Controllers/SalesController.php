<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use App\Models\Sale;
use App\Models\Stock;
use Illuminate\Support\Facades\Validator;

class SalesController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $carts = CartItem::where('status', 1)
            ->where('user_id', $user->id)
            ->get();
        $items = Item::all();
        return view('seller.make-sales.index', compact('items', 'carts'));
    }

    public function fetchCodes(Request $request)
    {
        $markGlassId = $request->input('mark_glass_id');
        $codes = Item::where('mark_glasses', $markGlassId)->join('codes', 'items.code_id', '=', 'codes.id')->pluck('codes.code_name', 'items.code_id')->toArray();
        return response()->json($codes);
    }

    public function fetchColors(Request $request)
    {
        $markGlassId = $request->mark_glass_id;
        $codeId = $request->code_id;

        // Fetch colors based on mark_glass_id and code_id
        $colors = Item::where('mark_glasses', $markGlassId)->where('code_id', $codeId)->join('colors', 'items.color_id', '=', 'colors.id')->pluck('colors.color_name', 'items.color_id')->toArray();

        return response()->json($colors);
    }

    public function addToCart(Request $request)
    {
        $user = Auth::user();

        // Generate random number for the sale code
        $randomNumber = rand(100000, 999999);
        $random = 'SALE-INVOICE' . $randomNumber;

        // Validate the incoming request data
        $validatedData = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Fetch the selected item based on the mark_glass, code_id, and color_id
        $item = Item::where('mark_glasses', $request->mark_glass)
            ->where('code_id', $request->code_id)
            ->where('color_id', $request->color_id)
            ->firstOrFail();

        // Calculate the amount based on the selected item's price and the quantity entered
        $amount = $item->price * $validatedData['quantity'];

        // Check if the item already exists in the cart with status 1
        $existingCartItem = CartItem::where('item_id', $item->id)
            ->where('user_id', $user->id)
            ->where('status', 1)
            ->first();

        if ($existingCartItem) {
            // Update existing cart item quantity and amount
            $existingCartItem->qty += $validatedData['quantity'];
            $existingCartItem->amount += $amount;
            $existingCartItem->save();

            // Return a JSON response indicating success
            return redirect()->back()->with('success', 'item updated on cart!');
        } else {
            // Create a new cart item with the validated data and generated sale code
            $cartItem = CartItem::create([
                'item_id' => $item->id,
                'qty' => $validatedData['quantity'],
                'user_id' => $user->id,
                'sale_code' => $random,
                'price' => $item->price,
                'amount' => $amount,
            ]);

            // Return a JSON response indicating success
            return redirect()->back()->with('success', 'item added on cart!');
        }
    }

    public function checkout($id)
    {
        $user = Auth::user();
        $data = CartItem::where('user_id', $user->id)
            ->where('status', 1)
            ->where('sale_code', $id)
            ->get();
        return view('seller.make-sales.edit', compact('data'));
    }

    public function clearCart()
    {
        try {
            // Find all cart items for the current user and delete them
            CartItem::where('user_id', Auth::id())->delete();

            return response()->json([
                'status' => 'success',
                'msg' => 'Cart cleared successfully',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'msg' => $th->getMessage(),
            ]);
        }
    }

    // Method to remove an individual item from the cart

    public function removeFromCart($id)
    {
        try {
            // Find the cart item by ID and user ID
            $cartItem = CartItem::where('item_id', $id)->where('user_id', Auth::id())->first();

            if ($cartItem) {
                // Delete the cart item
                $cartItem->delete();

                return response()->json([
                    'status' => 'success',
                    'msg' => 'Item deleted successfully',
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'msg' => 'Record not found',
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'msg' => $th->getMessage(),
            ]);
        }
    }

    public function remove($id)
    {
        $user = Auth::user();
        try {
            $data = CartItem::where('item_id', $id)
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
                ->where('status', 1)
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

        return redirect()->route('seller.sales.index')->with('success', 'Items sold successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
