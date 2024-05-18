<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Session;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use App\Models\Sale;
use App\Models\Stock;
use App\Models\Lens;
use App\Models\StockLens;
use App\Models\CartLens;
use Illuminate\Support\Facades\Validator;

class SalesController extends Controller
{
    public function fetchCodes(Request $request)
    {
        $markGlassId = $request->input('mark_glass_id');
        $codes = Item::where('mark_glasses', $markGlassId)->join('codes', 'items.code_id', '=', 'codes.id')->pluck('codes.code_name', 'items.code_id')->toArray();
        return response()->json($codes);
    }

    // public function fetchColors(Request $request)
    // {
    //     $markGlassId = $request->mark_glass_id;
    //     $codeId = $request->code_id;

    //     // Fetch colors based on mark_glass_id and code_id
    //     $colors = Item::where('mark_glasses', $markGlassId)->where('code_id', $codeId)->join('colors', 'items.color_id', '=', 'colors.id')->pluck('colors.color_name', 'items.color_id')->toArray();

    //     return response()->json($colors);
    // }
    public function fetchColors(Request $request)
    {
        $markGlassId = $request->mark_glass_id;
        $codeId = $request->code_id;

        // Fetch colors and prices based on mark_glass_id and code_id
        $items = Item::where('mark_glasses', $markGlassId)->where('code_id', $codeId)->join('colors', 'items.color_id', '=', 'colors.id')->select('items.color_id', 'colors.color_name', 'items.price')->get();

        return response()->json($items);
    }

    public function addToCart(Request $request)
    {
        $user = Auth::user();

        // Validate the incoming request data
        $validatedData = $request->validate([
            'quantity' => 'required|integer|min:1',
            'mark_glass_id' => 'required|integer',
            'code_id' => 'required|string',
            'color_id' => 'required|string',
        ]);

        // Fetch the selected item based on the mark_glass_id, code_id, and color_id
        $item = Item::where('mark_glasses', $request->mark_glass_id)
            ->where('code_id', $request->code_id)
            ->where('color_id', $request->color_id)
            ->firstOrFail();

        if (!$item) {
            return redirect()->back()->with('error', 'Item does not exist in stock');
        }

        // Fetch stock information for the selected item
        $stock = Stock::where('item_id', $item->id)->first();

        // Check if the requested quantity exceeds available stock
        if ($stock->item_quantity < $request->quantity) {
            return redirect()->back()->with('error', 'Insufficient stock');
        }

        // Calculate the amount based on the selected item's price and the quantity entered
        $amount = $item->price * $validatedData['quantity'];
        // Check if the item already exists in the cart with status 1
        $existingCartItem = CartItem::where('item_id', $item->id)
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
            $random = 'SALE-INVOICE' . $randomNumber;

            // Create a new cart item with the validated data and generated sale code
            $cartItem = CartItem::create([
                'item_id' => $item->id,
                'qty' => $validatedData['quantity'],
                'user_id' => $user->id,
                'sale_code' => $random,
                'price' => $item->price,
                'amount' => $amount,
            ]);

            // Return a redirect with success message
            return redirect()->back()->with('success', 'Item added to cart!');
        } catch (\Exception $e) {
            // Return a redirect with error message if an exception occurs
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function checkout($id)
    {
        $user = Auth::user();
        $data = CartItem::where('user_id', $user->id)
            ->where('status', 1)
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

    // Controller
    public function update(Request $request, $id)
    {
        $insuranceId = Session::get('insurance_id');
        $user = Auth::user();

        // Validate the form data
        $validator = Validator::make($request->all(), [
            'buyer_id' => 'required|integer',
            'operator_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $buyer = Customer::where('id', $request->buyer_id)->first();
        $names = $buyer->customer_name;
        $phone = $buyer->customer_phone;
        $amount = Session::get('amount_to_pay');

        //send sms
        $sender = 'REC';
        $content = 'Dear ' . $names. ' You bill is ' .$amount. ' Rwf. Please proceed to pay, for any questions feel free to contact us on 0788531106 for assistance. Thank you';

        $params = [
            'sender'    => $sender,
            'content'   => $content,
            'msisdn'    => $phone,
            'username'  => 'bulksms',
            'password'  => 'bulksms345',
        ];

        $smsResponse = $this->sendSms($params);

        try {
            // Update stock based on updated purchases
            $cartItems = CartItem::where('user_id', $user->id)
                ->where('status', 1)
                ->get();

            foreach ($cartItems as $cartItem) {
                Sale::create([
                    'item_id' => $cartItem->item_id,
                    'buyer_id' => $request->buyer_id,
                    'cart_id' => $cartItem->id,
                    'seller_id' => $request->operator_id,
                    'product_id' => $cartItem->product_id,
                    'item_quantity' => $cartItem->qty,
                    'paypos' => $request->paypos,
                    'insurance_id' => $insuranceId,
                    'paymomo' => $request->paymomo,
                    'paycash' => $request->paycash,
                ]);

                // Update all purchases with the specified purchase_code
                CartItem::where('user_id', $user->id)
                    ->where('status', 1)
                    ->update([
                        'buyer_id' => $request->buyer_id,
                        'status' => 2,
                    ]);

                // Update stock
                if ($cartItem->product_id == 1) {
                    Stock::where('item_id', $cartItem->item_id)->decrement('item_quantity', $cartItem->qty);
                } else {
                    StockLens::where('item_id', $cartItem->item_id)->decrement('item_quantity', $cartItem->qty);
                }
            }

            return redirect()->route('seller.invoice.index')->with('success', 'Items sold successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function performa($id)
    {
        $cartItems = CartItem::where('sale_code', $id)->get();

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

    private function sendSms($params)
    {
        $ch = curl_init();
        $url = 'http://164.92.112.235:9090/sendSmsHandler/sendSimpleSms';

        if (count($params) > 0) {
            $query = http_build_query($params);
            curl_setopt($ch, CURLOPT_URL, "$url?$query");
        } else {
            curl_setopt($ch, CURLOPT_URL, $url);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);

        $smsResponse = json_decode($output, true);

        curl_close($ch);

        return $smsResponse;
    }
}
