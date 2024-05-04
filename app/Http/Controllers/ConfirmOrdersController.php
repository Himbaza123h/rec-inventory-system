<?php

namespace App\Http\Controllers;

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
use Illuminate\Support\Facades\Session;
use App\Models\PurchaseLens;

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
        $pendings = Order::where('status', 'pending')->get();
        // Paginate the sales data manually
        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 7;
        $pendingsCollection = collect($pendings);
        $currentPageItems = $pendingsCollection->slice(($page - 1) * $perPage, $perPage)->all();
        $pendings = new LengthAwarePaginator($currentPageItems, count($pendingsCollection), $perPage);
        $routeName = 'admin.pending.order.details';
        $pendings->setPath(route($routeName));
        return view('admin.orders.pending.index', compact('pendings'));
    }

    public function accepted()
    {
        $accepted = Order::where('status', 'accepted')->get();
        // Paginate the sales data manually
        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 7;
        $acceptedCollection = collect($accepted);
        $currentPageItems = $acceptedCollection->slice(($page - 1) * $perPage, $perPage)->all();
        $accepted = new LengthAwarePaginator($currentPageItems, count($acceptedCollection), $perPage);
        $routeName = 'admin.confirm.orders';
        $accepted->setPath(route($routeName));
        return view('admin.orders.confirm.index', compact('accepted'));
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
        $orderList = Order::where('order_id', $id)->where('status', 'accepted')->get();

        return view('admin.orders.confirm.edit', compact('orderList', 'id'));
    }

    public function confirm(Request $request, $id)
    {
        $request->validate([
            'payment_method' => 'required',
        ]);

        // Retrieve the orders by their ID
        $orders = Order::where('order_id', $id)->get();

        // Update the status of each order to "paid"
        foreach ($orders as $order) {
            $order->status = 'paid';
            $order->save();
        }

        // Process stock updates for each order
        foreach ($orders as $order) {
            // Check if the item exists in stock

            if ($order->product_id == 2) {
                $existingStockLens = StockLens::where('item_id', $order->item_id)
                    ->where('product_id', $order->product_id)
                    ->where('status', true)
                    ->first();

                if ($existingStockLens) {
                    $existingStockLens->item_quantity += $order->qty;
                    $existingStockLens->remaining += $order->qty;
                    $existingStockLens->save();
                } else {
                    // If the item does not exist in stock, create a new stock entry
                    $stockLens = new StockLens();
                    $stockLens->item_id = $order->item_id;
                    $stockLens->purchase_id = $order->order_id;
                    $stockLens->product_id = $order->product_id;
                    $stockLens->item_quantity = $order->qty;
                    $stockLens->save();
                }
            } else {
                $existingStock = Stock::where('item_id', $order->item_id)
                    ->where('product_id', $order->product_id)
                    ->where('status', true)
                    ->first();

                if ($existingStock) {
                    $existingStock->item_quantity += $order->qty;
                    $existingStock->remaining += $order->qty;
                    $existingStock->save();
                } else {
                    // If the item does not exist in stock, create a new stock entry
                    $stock = new Stock();
                    $stock->item_id = $order->item_id;
                    $stock->purchase_id = $order->order_id;
                    $stock->product_id = $order->product_id;
                    $stock->item_quantity = $order->qty;
                    $stock->remaining = $order->qty;
                    $stock->save();
                }
            }
        }

        // Redirect back or to any other route as needed
        return redirect()->back()->with('success', 'Orders confirmed successfully!');
    }

    public function financial()
    {$today = Carbon::today();
        $user = Auth::user();

        if ($user->role == 'admin') {
            $orders = Sale::select(
                DB::raw('DATE(created_at) as date'), DB::raw('SUM(paycash) as cash'), DB::raw('SUM(paymomo) as momo'), DB::raw('SUM(paypos) as pos'), DB::raw('SUM(insurance_id) as assurance'))->groupBy('date')->get();
        } else {
            $orders = Sale::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(paycash) as cash'), DB::raw('SUM(paymomo) as momo'), DB::raw('SUM(paypos) as pos'), DB::raw('SUM(insurance_id) as assurance'))->groupBy('date')
            ->whereDate('created_at', $today)
            ->get();
        }

        $totalAmount = $orders->sum(function ($order) {
            return $order->cash + $order->momo + $order->pos + $order->assurance;
        });

        return view('reports.stats.index', compact('orders', 'totalAmount'));
    }
}
