<?php

namespace App\Http\Controllers;

use App\Http\Controllers\seller\CartController;
use Illuminate\Http\Request;
use App\Models\PurchaseCart;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Supplier;
use App\Models\Lens;
use App\Models\Category;

class PurchaseCartController extends Controller
{
    public function index()
    {
        // $categories = Category::where()
        $carts = PurchaseCart::where('status', 1)->get();

        return view('purchase.index', compact('carts'));
    }
    public function addCart(Request $request)
    {
        $user = Auth::user();
        // Validate the incoming request data
        $validatedData = $request->validate([
            'supplier_id' => 'required|integer',
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
            'mark_glass_id' => 'required|integer',
            'code_id' => 'required|string',
            'color_id' => 'required|string',
            'purchase_price' => 'required|integer',
        ]);

        try {
            // Fetch the selected item based on the mark_glass_id, code_id, and color_id
            $item = Item::where('mark_glasses', $request->mark_glass_id)
                ->where('code_id', $request->code_id)
                ->where('product_category', $request->product_id)
                ->where('color_id', $request->color_id)
                ->firstOrFail();

            // Calculate the amount based on the selected item's price and the quantity entered
            $amount = $validatedData['purchase_price'] * $validatedData['quantity'];

            // Check if there's a row with the same supplier_id and status 1
            $existingOrder = PurchaseCart::where('supplier_id', $validatedData['supplier_id'])
                ->where('status', 1)
                ->first();

            if ($existingOrder) {
                // Use the current order_number
                $random = $existingOrder->order_number;
            } else {
                // Generate a new order number
                $randomNumber = rand(1000, 9999);
                $supplier = Supplier::findOrFail($validatedData['supplier_id']);
                $supplierName = substr($supplier->supplier_name, 0, 4);
                $random = strtoupper($supplierName) . '-' . $randomNumber;
            }

            // Check if there's an existing cart item with the same item_id
            $existingCartItem = PurchaseCart::where('item_id', $item->id)
                ->where('supplier_id', $validatedData['supplier_id'])
                ->where('product_id', $validatedData['product_id'])
                ->where('status', true)
                ->first();

            if ($existingCartItem) {
                // Update the quantity and amount of the existing cart item
                // $random = $existingCartItem->order_number;
                $existingCartItem->quantity = $validatedData['quantity'];
                $existingCartItem->supplier_id = $validatedData['supplier_id'];
                $existingCartItem->order_number = $random;
                $existingCartItem->amount = $amount;
                $existingCartItem->save();

                // Return a redirect with success message
                return redirect()->back()->with('success', 'Cart updated with new quantity!');
            } else {
                // $randomNumber = rand(1000, 9999);
                // $supplier = Supplier::findOrFail($validatedData['supplier_id']);
                // $supplierName = substr($supplier->supplier_name, 0, 4);
                // $random = strtoupper($supplierName) . '-' . $randomNumber;

                // Create a new cart item with the validated data and generated sale code
                $cartItem = PurchaseCart::create([
                    'item_id' => $item->id,
                    'quantity' => $validatedData['quantity'],
                    'supplier_id' => $validatedData['supplier_id'],
                    'order_number' => $random,
                    'product_id' => $validatedData['product_id'],
                    'price' => $validatedData['purchase_price'],
                    'uwabikoze' => $user->id,
                    'amount' => $amount,
                ]);

                // Return a redirect with success message
                return redirect()->back()->with('success', 'Item added to cart!');
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Return a redirect with error message if the item is not found
            return redirect()->back()->with('error', 'Item does not exist in stock');
        } catch (\Exception $e) {
            // Return a redirect with error message if an exception occurs
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function addLensCart(Request $request)
    {
        $user = Auth::user();
        // Validate the incoming request data
        $validatedData = $request->validate([
            'supplier_id' => 'required|integer',
            'product_id' => 'required|integer',
            'category_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
            'attribute_id' => 'required|string',
            'power_sph' => 'nullable|string',
            'power_cyl' => 'nullable|string',
            'power_axis' => 'nullable|string',
            'power_add' => 'nullable|string',
            'purchase_price' => 'required|integer',
        ]);

        try {
            $item = Lens::where('mark_lens', $request->category_id)
                ->where('lens_attribute', $request->attribute_id)
                // ->where('power_sph', $request->power_sph)
                // ->where('power_cyl', $request->power_cyl)
                // ->where('power_axis', $request->power_axis)
                // ->where('power_add', $request->power_add)
                ->firstOrFail();

            $amount = $validatedData['purchase_price'] * $validatedData['quantity'];

            $existingOrder = PurchaseCart::where('supplier_id', $validatedData['supplier_id'])
                ->where('status', 1)
                ->first();

            if ($existingOrder) {
                // Use the current order_number
                $random = $existingOrder->order_number;
            } else {
                // Generate a new order number
                $randomNumber = rand(1000, 9999);
                $supplier = Supplier::findOrFail($validatedData['supplier_id']);
                $supplierName = substr($supplier->supplier_name, 0, 4);
                $random = strtoupper($supplierName) . '-' . $randomNumber;
            }
            // Check if there's an existing cart item with the same item_id
            $existingCartItem = PurchaseCart::where('item_id', $item->id)
                ->where('supplier_id', $validatedData['supplier_id'])
                ->where('product_id', 2)
                ->where('status', true)
                ->first();

            if ($existingCartItem) {
                // Update the quantity and amount of the existing cart item
                // $random = $existingCartItem->order_number;
                $existingCartItem->quantity = $validatedData['quantity'];
                $existingCartItem->supplier_id = $validatedData['supplier_id'];
                $existingCartItem->order_number = $random;
                $existingCartItem->amount = $amount;
                $existingCartItem->save();

                // Return a redirect with success message
                return redirect()->back()->with('success', 'Cart updated with new quantity!');
            } else {
                // Create a new cart item with the validated data and generated sale code
                $cartItem = PurchaseCart::create([
                    'item_id' => $item->id,
                    'quantity' => $validatedData['quantity'],
                    'supplier_id' => $validatedData['supplier_id'],
                    'order_number' => $random,
                    'product_id' => $validatedData['product_id'],
                    'price' => $validatedData['purchase_price'],
                    'uwabikoze' => $user->id,
                    'amount' => $amount,
                ]);

                // Return a redirect with success message
                return redirect()->back()->with('success', 'Item added to cart!');
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Return a redirect with error message if the item is not found
            return redirect()->back()->with('error', 'Item does not exist in stock');
        } catch (\Exception $e) {
            // Return a redirect with error message if an exception occurs
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function addCartNew(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'target_client' => 'required|string',
            'mark_glass_id' => 'required|string',
            'code_id' => 'required|string',
            'product' => 'required|integer',
            'lens_width' => 'required|numeric',
            'bridge_width' => 'required|numeric',
            'temple_length' => 'required|numeric',
            'color_id' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'supplier_id' =>'required|string'


        ]);
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        } else {
            $amount = $request->price* $request->quantity;

            $existingOrder = PurchaseCart::where('supplier_id', $request->supplier_id,)
                ->where('status', 1)
                ->first();

            if ($existingOrder) {
                // Use the current order_number
                $random = $existingOrder->order_number;
            } else {
                // Generate a new order number
                $randomNumber = rand(1000, 9999);
                $supplier = Supplier::findOrFail($request->supplier_id,);
                $supplierName = substr($supplier->supplier_name, 0, 4);
                $random = strtoupper($supplierName) . '-' . $randomNumber;
            }
            try {
                $newItem = new Item();
                $newItem->target_client = $request->target_client;
                $newItem->mark_glasses = $request->mark_glass_id;
                $newItem->code_id = $request->code_id;
                $newItem->product_category = $request->product;
                $newItem->lens_width = $request->lens_width;
                $newItem->bridge_width = $request->bridge_width;
                $newItem->temple_length = $request->temple_length;
                $newItem->color_id = $request->color_id;
                $newItem->price = $request->price;
                $newItem->save();

                $cartItem = PurchaseCart::create([
                    'item_id' => $newItem->id,
                    'quantity' => $request->quantity,
                    'supplier_id' => $request->supplier_id,
                    'order_number' => $random,
                    'product_id' => $request->product,
                    'price' => $request->price,
                    'uwabikoze' => $user->id,
                    'amount' => $amount,
                ]);

                return redirect()->route('admin.purchase.order.index')->with('success', 'New Item created and order placed successfully!');
            } catch (\Throwable $th) {
                return response()->json([
                    'status' => 'error',
                    'msg' => $th->getMessage(),
                ]);
            }
        }
    }

    public function remove($id)
    {
        $cart = PurchaseCart::findOrFail($id);

        $cart->status = 3;
        $cart->save();

        return redirect()->back()->with('success', ' item removed on cart successfully.');
    }

    public function accept()
    {
        $user = Auth::user();

        $carts = PurchaseCart::where('uwabikoze', $user->id)
            ->where('status', true)
            ->get();
        foreach ($carts as $cart) {
            $cart->status = 2;
            $cart->save();
        }
        return redirect()->route('admin.confirm.orders')->with('success', 'All items with order by ' . $user->name . ' accepted successfully.');
        // return redirect()
        //     ->back()
        //     ->with('success', 'All items with order by ' . $user->name . ' accepted successfully.');
    }

    public function draft()
    {
        $user = Auth::user();
        $carts = PurchaseCart::where('status', 1)
            ->where('uwabikoze', $user->id)
            ->get();
        foreach ($carts as $cart) {
            $cart->status = 4;
            $cart->save();
        }

        return redirect()->back()->with('success', 'All items on cart saved as draft successfuly');
    }
}
