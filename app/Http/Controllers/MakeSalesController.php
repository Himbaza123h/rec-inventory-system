<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Seller;
use Illuminate\Support\Facades\Session;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use App\Models\Sale;
use App\Models\Stock;
use App\Models\Lens;
use App\Models\StockLens;

class MakeSalesController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $carts = CartItem::where('status', 1)->get();
        $itemIdsInStock = Stock::pluck('item_id')->toArray();

        // Retrieve items where their IDs exist in the $itemIdsInStock array
        $items = Item::whereIn('id', $itemIdsInStock)->where('product_category', 1)->where('status', true)->get();
        $items1 = Item::whereIn('id', $itemIdsInStock)->where('product_category', 3)->where('status', true)->get();
        $items2 = Item::whereIn('id', $itemIdsInStock)->where('product_category', 4)->where('status', true)->get();
        return view('seller.make-sales.index', compact('items', 'items1', 'items2', 'carts'));
    }
    public function store(Request $request)
    {
        
        $user = Auth::user();
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'quantity' => 'required|integer|min:1',
                'mark_glass_id' => 'nullable|integer',
                'code_id' => 'nullable|string',
                'color_id' => 'nullable|string',
                'attribute_id' => 'nullable|integer',
                'category_id' => 'nullable|string',
                'power_id' => 'nullable|string',
                'seller_id' => 'nullable|integer',
                'insurance' => 'nullable|integer',
                'insurance_number' => 'nullable|string',
                'covered' => 'nullable|string',
                'sale_price' => 'required|string',
            ]);

            $amount = 0;
            $data = $validatedData['insurance'];
            Session::put('insurance_id', $data);

            // Fetch the product type from the request
            $productType = $request->input('product_id');

            if ($productType == 1 || $productType == 3 || $productType == 4) {
                // Fetch the glass item based on provided attributes
                $glassItem = Item::where('mark_glasses', $request->mark_glass_id)
                    ->where('code_id', $request->code_id)
                    ->where('color_id', $request->color_id)
                    ->first();

                if (!$glassItem) {
                    return redirect()->back()->with('error', 'Glass item does not exist in stock');
                }

                // Fetch stock information for the selected glass item
                $glassStock = Stock::where('item_id', $glassItem->id)->first();

                // Check if the requested quantity exceeds available stock
                if ($glassStock->item_quantity < $request->quantity) {
                    return redirect()->back()->with('error', 'Insufficient stock for glass item');
                }

                $amount += $validatedData['sale_price'] * $validatedData['quantity'];
            } elseif ($productType == 2) {
                $lensItem = Lens::where('mark_lens', $request->category_id)
                    ->where('lens_attribute', $request->attribute_id)
                    ->where('lens_power', $request->power_id)
                    ->first();

                if (!$lensItem) {
                    return redirect()->back()->with('error', 'Lens item does not exist in stock');
                }

                // Fetch stock information for the selected lens item
                $lensStock = StockLens::where('item_id', $lensItem->id)->first();

                // Check if the requested quantity exceeds available stock
                if ($lensStock->item_quantity < $request->quantity) {
                    return redirect()->back()->with('error', 'Insufficient stock for lens item');
                }

                $amount += $validatedData['sale_price'] * $validatedData['quantity'];
            }
            $existingCartItem = CartItem::where('item_id', $productType == 1 ? $glassItem->id : $lensItem->id)
                ->where('status', 1)
                ->where('product_id', $productType)
                ->first();

            if ($existingCartItem) {
                // Update the quantity and amount of the existing cart item
                $existingCartItem->qty += $validatedData['quantity'];
                $existingCartItem->amount += $amount;
                $existingCartItem->covered += $validatedData['covered'];
                $existingCartItem->insurance += $validatedData['insurance'];
                $existingCartItem->insurance_number += $validatedData['insurance_number'];
                $existingCartItem->save();

                // Return a redirect with success message
                return redirect()->back()->with('success', 'Cart updated with new quantity!');
            }
            // Generate a random sale code
            $randomNumber = rand(100000, 999999);
            $random = 'CUST-SALE-INVOICE' . $randomNumber;

            // Create a new cart item with the validated data and generated sale code
            CartItem::create([
                'item_id' => $productType == 1 ? $glassItem->id : $lensItem->id,
                'product_id' => $productType,
                'qty' => $validatedData['quantity'],
                'sale_code' => $random,
                'price' => $validatedData['sale_price'],
                'user_id' => $user->id,
                'amount' => $amount,
                'covered' => $validatedData['covered'],
                'insurance' => $validatedData['insurance'],
                'insurance_number' => $validatedData['insurance_number'],
            ]);

            // Return a redirect with success message
            return redirect()->back()->with('success', 'Item added to cart!');
        } catch (\Exception $e) {
            // Return a redirect with error message if an exception occurs
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
