<?php

namespace App\Http\Controllers;

use App\Models\PurchaseCart;
use Illuminate\Http\Request;
use App\Models\Purchase;
use Vtiful\Kernel\Format;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\StockLens;
use Illuminate\Support\Carbon;
use App\Models\Sale;
use App\Models\Supplier;
use Illuminate\Support\Facades\Session;
use App\Models\PurchaseLens;
use App\Models\Item;

class ConfirmOrdersController extends Controller
{
    public function store(Request $request)
    {
        $productId = $request->input('product_id');
        $pendingOrder = Order::where('status', 'pending')->first();

        if ($pendingOrder) {
            // If there is a pending order, use its Pcode for the new orders
            $Pcode = $pendingOrder->order_id;
        } else {
            // If there is no pending order, generate a new Pcode
            $Pcode = $request->input('purchaseCode');
        }

        Session::put('p_code', $Pcode);

        foreach ($request->selected as $itemId) {
            $quantity = $request->input("Qty_$itemId");
            $price = $request->input("price_$itemId");
            $total = $quantity * $price;
            $date = date('Y-m-d');

            // Check if a record exists with the given item ID and status 'pending'
            $existingPurchase = Order::where('item_id', $itemId)->where('status', 'pending')->where('product_id', $productId)->first();

            if ($existingPurchase) {
                // If an existing record is found, update its quantity
                $existingPurchase->update([
                    'qty' => $quantity,
                    'price' => $price,
                    'amount' => $total,
                    'order_id' => $Pcode, // Update the Pcode as well
                ]);
            } else {
                // If no existing record is found, create a new one
                $new = new Order();
                $new->item_id = $itemId;
                $new->order_id = $Pcode;
                $new->qty = $quantity;
                $new->price = $price;
                $new->product_id = $productId;
                $new->amount = $total;
                $new->save();
            }
        }

        // Redirect to the edit route with the created purchase code
        return redirect()->route('admin.pending.order.details')->with('success', ' successfully ordered!');
    }

    public function details()
    {
        // Retrieve pendings grouped by order_number where status is 1
        $groupedPendings = PurchaseCart::where('status', 1)->get()->groupBy('order_number');

        // Calculate total amount for each order number
        $orders = [];
        foreach ($groupedPendings as $orderNumber => $pendings) {
            $totalAmount = $pendings->sum('amount');
            $orders[] = [
                'order_number' => $orderNumber,
                'total_amount' => $totalAmount,
                'items' => $pendings,
            ];
        }

        return view('admin.orders.pending.index', compact('orders'));
    }

    public function draft()
    {
        // Retrieve pendings grouped by order_number where status is 1
        $groupedPendings = PurchaseCart::where('status', 4)->get()->groupBy('order_number');

        // Calculate total amount for each order number
        $orders = [];
        foreach ($groupedPendings as $orderNumber => $pendings) {
            $totalAmount = $pendings->sum('amount');
            $orders[] = [
                'order_number' => $orderNumber,
                'total_amount' => $totalAmount,
                'items' => $pendings,
            ];
        }

        return view('admin.orders.draft.index', compact('orders'));
    }

    public function accepted()
    {
        // Retrieve pendings grouped by order_number where status is 1
        $groupedPendings = PurchaseCart::whereIn('status', [2, 5])
            ->get()
            ->groupBy('order_number');

        // Calculate total amount for each order number
        $orders = [];
        foreach ($groupedPendings as $orderNumber => $pendings) {
            $totalAmount = $pendings->sum('amount');
            $orderInfo = $pendings->first();
            $supplier = Supplier::find($orderInfo->supplier_id);
            $orderDate = $orderInfo->created_at->format('Y-m-d');
            $orderStatus = $orderInfo->status;
            $orderPrefix = $orderInfo->prefix;
            $orders[] = [
                'order_number' => $orderNumber,
                'total_amount' => $totalAmount,
                'items' => $pendings,
                'supplier' => $supplier,
                'order_date' => $orderDate,
                'status' => $orderStatus,
                'prefix' => $orderPrefix,
            ];
        }
        return view('admin.orders.confirm.index', compact('orders'));
    }

    public function delete($id)
    {
        $detail = Order::find($id);

        if (!$detail) {
            return redirect()->back()->with('error', 'Order detail not found.');
        }

        $detail->delete();

        return redirect()->back()->with('success', 'Order detail successfully removed.');
    }

    public function send(Request $request)
    {
        $pCode = Session::get('p_code');
        // Retrieve the supplier ID from the form
        $supplierId = $request->input('supplier_id');

        // Find pending orders with the same Pcode
        $pendingOrders = Order::where('order_id', $pCode)->where('status', 'pending')->get();

        // Update each pending order
        foreach ($pendingOrders as $order) {
            $order->update([
                'status' => 'accepted',
                'supplier_id' => $supplierId,
            ]);
        }

        // Redirect back or to any other route as needed
        return redirect()->back()->with('success', 'Orders sent successfully!');
    }

    public function singleOrder($id)
    {
        $orderList = PurchaseCart::where('order_number', $id)->where('status', 2)->get();

        return view('admin.orders.confirm.edit', compact('orderList', 'id'));
    }

    public function reconfirm($id)
    {
        $orderList = PurchaseCart::where('order_number', $id)->get();
        foreach ($orderList as $order) {
            $order->prefix = 1;
            $order->save();
        }
        return redirect()->back()->with('success', 'Marked as paid');
    }
    public function confirm(Request $request, $id)
    {
        $request->validate([
            'payment_method' => 'required',
        ]);

        // Retrieve the orders by their ID
        $orders = PurchaseCart::where('order_number', $id)->get();

        // Update the status of each order to "paid"
        foreach ($orders as $order) {
            $order->status = 5;
            $order->prefix = $request->payment_method;
            $order->save();
        }

        // Process stock updates for each order
        foreach ($orders as $order) {
            // Check if the item exists in stock

            if ($order->product_id == 2) {
                $existingStockLens = StockLens::where('item_id', $order->item_id)
                    ->where('product_id', $order->product_id)
                    ->first();

                if ($existingStockLens) {
                    $existingStockLens->item_quantity += $order->quantity;
                    $existingStockLens->remaining += $order->quantity;
                    $existingStockLens->save();
                } else {
                    // If the item does not exist in stock, create a new stock entry
                    $stockLens = new StockLens();
                    $stockLens->item_id = $order->item_id;
                    $stockLens->purchase_id = $order->order_id;
                    $stockLens->product_id = $order->product_id;
                    $stockLens->item_quantity = $order->quantity;
                    $stockLens->save();
                }
            } else {
                $existingStock = Stock::where('item_id', $order->item_id)
                    ->where('product_id', $order->product_id)
                    ->first();

                if ($existingStock) {
                    $existingStock->item_quantity += $order->quantity;
                    $existingStock->remaining += $order->quantity;
                    $existingStock->save();
                } else {
                    // If the item does not exist in stock, create a new stock entry
                    $stock = new Stock();
                    $stock->item_id = $order->item_id;
                    $stock->purchase_id = $order->order_id;
                    $stock->product_id = $order->product_id;
                    $stock->item_quantity = $order->quantity;
                    $stock->remaining = $order->quantity;
                    $stock->save();
                }
            }
        }

        // Redirect back or to any other route as needed
        return redirect()->route('admin.confirm.orders')->with('success', 'Orders confirmed successfully!');
    }

    public function financial(Request $request)
    {
        $today = \Carbon\Carbon::today();
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
    
        $user = \Illuminate\Support\Facades\Auth::user();
    
        // Start the query
        $query = \App\Models\Sale::select(
            \Illuminate\Support\Facades\DB::raw('DATE(created_at) as date'),
            \Illuminate\Support\Facades\DB::raw('SUM(paycash) as cash'),
            \Illuminate\Support\Facades\DB::raw('SUM(paymomo) as momo'),
            \Illuminate\Support\Facades\DB::raw('SUM(paypos) as pos'),
            \Illuminate\Support\Facades\DB::raw('SUM(insurance_id) as assurance')
        );
    
        if ($user->role == 'admin') {
            $query->groupBy(\Illuminate\Support\Facades\DB::raw('DATE(created_at)'));
        } else {
            // If the user is not admin, group by date
            $query->groupBy(\Illuminate\Support\Facades\DB::raw('DATE(created_at)'));
            // Filter by today's date if not provided
            if (!$fromDate && !$toDate) {
                $query->whereDate('created_at', $today);
            }
        }
    
        // Filter by date range if provided
        if ($fromDate && $toDate) {
            $query->whereBetween(\Illuminate\Support\Facades\DB::raw('DATE(created_at)'), [$fromDate, $toDate]);
        }
    
        // Execute the query and get the results
        $orders = $query->get();
    
        // Calculate the total amount
        $totalAmount = $orders->sum(function ($order) {
            return $order->cash + $order->momo + $order->pos + $order->assurance;
        });
    
        // Return the view with data
        return view('reports.stats.index', compact('orders', 'totalAmount'));
    }
    
    
}
