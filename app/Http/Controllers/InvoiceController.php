<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $user = Auth::user();
        if ($user->role === 'admin') {
            $invoices = Sale::join('cart_items', 'sales.cart_id', '=', 'cart_items.id')->select('cart_items.sale_code', DB::raw('MAX(cart_items.created_at) as latest_date'))->groupBy('cart_items.sale_code')->orderBy('latest_date', 'desc')->get();
        } else {
            $invoices = Sale::join('cart_items', 'sales.cart_id', '=', 'cart_items.id')
            ->select('cart_items.sale_code', DB::raw('MAX(cart_items.created_at) as latest_date'))
            ->whereDate('cart_items.created_at', $today)
            ->groupBy('cart_items.sale_code')
            ->orderBy('latest_date', 'desc')
            ->get();
        }

        $data = null;

        return view('invoices.general.index', compact('data', 'invoices'));
    }

    public function InvoivebySellCode($id = null)
    {
        $today = Carbon::today();
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Make $id parameter nullable
            $invoices = Sale::join('cart_items', 'sales.cart_id', '=', 'cart_items.id')->select('cart_items.sale_code', DB::raw('MAX(cart_items.created_at) as latest_date'))->groupBy('cart_items.sale_code')->orderBy('latest_date', 'desc')->get();
        }
        else {
            $invoices = Sale::join('cart_items', 'sales.cart_id', '=', 'cart_items.id')->select('cart_items.sale_code', DB::raw('MAX(cart_items.created_at) as latest_date'))
            ->whereDate('cart_items.created_at', $today)
            ->groupBy('cart_items.sale_code')->orderBy('latest_date', 'desc')->get();   
        }
        $data = null;

        if ($id) {
            $data = CartItem::where('sale_code', $id)->get();
        }

        return view('invoices.general.index', compact('data', 'invoices'));
    }

    public function request()
    {
        return view('invoices.requested.index');
    }
}
