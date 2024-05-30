<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\StockLens;
use Illuminate\Support\Facades\Validator;
use App\Models\OrderItem;
use App\Models\PlacedOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = OrderItem::where('status', true)->get();
        return view('make-order.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $validatedData = $request->validate([
            'quantity' => 'required|integer|min:1',
            'attribute_id' => 'nullable|integer',
            'category_id' => 'nullable|string',
            'type_id' => 'nullable|string',
            'power_sph' => 'nullable|string',
            'power_cyl' => 'nullable|string',
            'power_axis' => 'nullable|string',
            'power_add' => 'nullable|string',
            'insurance' => 'nullable|integer',
            'insurance_number' => 'nullable|string',
            'covered_amount' => 'nullable|string',
            'sale_price' => 'required|string',
        ]);

        $lensItem = \App\Models\Lens::where('mark_lens', $validatedData['category_id'])
            ->where('lens_attribute', $validatedData['attribute_id'])
            ->first();

        if (!$lensItem) {
            return redirect()->back()->with('error', 'There was something wrong!!');
        }

        $existingOrderItem = OrderItem::where('seller_id', $user->id)
            ->where('status', true)
            ->first();

        if ($existingOrderItem) {
            $orderCode = $existingOrderItem->order_code;
        } else {
            // Generate a new order number
            $randomNumber = rand(1000, 9999);
            $orderCode = 'ORDER-INV' . '-' . $randomNumber;
        }

        $existingOrder = OrderItem::where('item_id', $lensItem->id)
            ->where('status', 1)
            ->where('seller_id', $user->id)
            ->first();

        if ($existingOrder) {
            // Update quantity and amount
            $existingOrder->quantity += $validatedData['quantity'];
            $existingOrder->amount = $existingOrder->quantity * $validatedData['sale_price'];
            $existingOrder->save();

            return redirect()->back()->with('success', 'Order has been updated successfully!');
        } else {
            // Calculate the total amount
            $totalAmount = $validatedData['quantity'] * $validatedData['sale_price'];

            // Create a new order item
            $orderItem = OrderItem::create([
                'item_id' => $lensItem->id,
                'order_code' => $orderCode,
                'quantity' => $validatedData['quantity'],
                'amount' => $totalAmount,
                'insurance_id' => $validatedData['insurance'] ?? null,
                'insurance_number' => $validatedData['insurance_number'] ?? null,
                'amount_covered' => $validatedData['covered_amount'] ?? null,
                'amount_payed' => $validatedData['covered_amount'] ? $validatedData['covered_amount'] : 0,
                'amount_remaining' => $validatedData['covered_amount'] ? $totalAmount - $validatedData['covered_amount'] : $totalAmount,
                'status' => 1,
                'seller_id' => $user->id,
            ]);

            if ($orderItem) {
                return redirect()->back()->with('success', 'Order has been placed successfully!');
            } else {
                return redirect()->back()->with('error', 'Failed to place the order. Please try again.');
            }
        }
    }

    public function delete($id)
    {
        try {
            $data = OrderItem::findOrFail($id);
            $data->delete();

            return redirect()->back()->with('success', 'Order successfully removed!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Order not found');
        } catch (\Throwable $th) {
            return redirect()
                ->back()
                ->with('error', 'An error occurred: ' . $th->getMessage());
        }
    }

    public function proceed($id)
    {
        $orders = OrderItem::where('order_code', $id)->where('status', true)->get();
        return view('make-order.proceed', compact('orders'));
    }

    public function place(Request $request, $id)
    {
        $user = Auth::user();

        // Validate request data
        $validator = Validator::make($request->all(), [
            'operator_id' => 'required|integer',
            'buyer_id' => 'required|integer',
            'insurance_percentage' => 'nullable|numeric',
            'ticket_moderateur' => 'nullable|numeric',
            'top_up_hidden' => 'nullable|numeric',
            'covered_hidden' => 'nullable|numeric',
            'paycash' => 'nullable|numeric',
            'paymomo' => 'nullable|numeric',
            'paypos' => 'nullable|numeric',
            'partial_to_pay' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Find the order item
        $order = OrderItem::where('order_code', $id)->where('status', true)->get();

        if ($request->has('partial_to_pay')) {
            $type = 0;
            $partialAmount = $request->input('partial_to_pay');
            $pos = $request->input('paypos', 0);
            $momo = $request->input('paymomo', 0);
            $cash = $request->input('paycash', 0);
            $totalPayment1 = $pos + $momo + $cash;
            // if ($totalPayment1 != $partialAmount) {
            //     return redirect()->back()->with('error', 'Payment amount does not match the partial amount.');
            // }
        } else {
            // User is paying full amount
            $type = 1;
            $fullToPay = $request->input('full_to_pay');
            $pos = $request->input('paypos', 0);
            $momo = $request->input('paymomo', 0);
            $cash = $request->input('paycash', 0);
            $totalPayment = $pos + $momo + $cash;
            // if ($totalPayment != $fullToPay) {
            //     return redirect()->back()->with('error', 'Payment amount does not match the full amount.');
            // }
        }

        $ticketmodurateur = ($request->covered_hidden * $request->insurance_percentage) / 100;
        $total_amount = $ticketmodurateur + $request->top_up_hidden;

        // Create a new placed order record
        $placedOrder = PlacedOrder::create([
            'order_code' => $order[0]->order_code,
            'operator_id' => $request->operator_id,
            'buyer_id' => $request->buyer_id,
            'insurance_percentage' => $request->insurance_percentage,
            'ticket_moderateur' => $ticketmodurateur,
            'top_up_amount' => $request->top_up_hidden,
            'payment_method_pos' => $request->paypos,
            'payment_method_momo' => $request->paymomo,
            'payment_method_cash' => $request->paycash,
            'totalAmount' => $total_amount,
            'type' => $type,
        ]);

        foreach ($order as $item) {
            $item->status = 2;
            $item->save();
        }

        return redirect()->route('seller.manage.orders.status')->with('success', 'Order successfully placed.');
    }

    public function accepted()
    {
        // Calculate total amount for each order number
        $orders = PlacedOrder::where('status', 'pending')->get();
        return view('make-order.accepted', compact('orders'));
    }

    public function confirm($id)
    {
        // Start a database transaction
        DB::beginTransaction();

        try {
            // Retrieve the order items
            $orderItems = OrderItem::where('order_code', $id)->get();

            foreach ($orderItems as $orderItem) {
                // Find the corresponding StockLens
                $stockLens = StockLens::where('item_id', $orderItem->item_id)->first();

                if ($stockLens) {
                    // Check if the stock quantity is sufficient
                    if ($stockLens->item_quantity >= $orderItem->quantity) {
                        // Update the item quantity
                        $stockLens->item_quantity -= $orderItem->quantity;
                        $stockLens->save();

                        // Update order

                        $orderItem->amount_remaining = 0;
                        $orderItem->amount_payed = $orderItem->amount;
                        $orderItem->save();
                        // Find the placed order
                        $order = PlacedOrder::where('order_code', $id)->firstOrFail();
                        // $order
                        $order->status = 'received';
                        $order->save();

                        // Create a sale record
                        Sale::create([
                            'item_id' => $orderItem->item_id,
                            'buyer_id' => $order->buyer_id,
                            'cart_id' => $orderItem->order_code,
                            'seller_id' => $order->operator_id,
                            'product_id' => 2, // Assuming a constant value for product_id
                            'item_quantity' => $orderItem->quantity,
                            'paypos' => $order->payment_method_pos,
                            'insurance_id' => $orderItem->insurance_id,
                            'paymomo' => $order->payment_method_momo,
                            'paycash' => $order->payment_method_cash,
                        ]);
                    } else {
                        // If stock is not enough, rollback the transaction and redirect back with an error message
                        DB::rollBack();
                        return redirect()->back()->with('error', 'Insufficient stock for some items.');
                    }
                } else {
                    // If no stock entry is found for the item, rollback the transaction and return with an error message
                    DB::rollBack();
                    return redirect()
                        ->back()
                        ->with('error', 'Stock item not found for item ID: ' . $orderItem->item_id);
                }
            }

            // Commit the transaction
            DB::commit();

            return redirect()->back()->with('success', 'Order successfully confirmed.');
        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();
            return redirect()
                ->back()
                ->with('error', 'An error occurred while confirming the order: ' . $e->getMessage());
        }
    }
}
