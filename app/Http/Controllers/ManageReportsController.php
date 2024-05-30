<?php

namespace App\Http\Controllers;

use App\Models\Pending;
use App\Models\PlacedOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class ManageReportsController extends Controller
{
    public function orders()
    {
        if (Auth::user()->role == 'admin') {
            $orders = OrderItem::all();
        } else {
            $orders = OrderItem::whereDate('created_at', Carbon::today())->get();
        }

        return view('reports.general.orders.index', compact('orders'));
    }

    public function pendings()
    {
        if (Auth::user()->role == 'admin') {
            $orders = Pending::get();
        } else {
            $orders = Pending::whereDate('created_at', Carbon::today())->get();
        }
        return view('reports.general.pendings.index', compact('orders'));
    }

    public function partials()
    {
        if (Auth::user()->role == 'admin') {
            $orders = PlacedOrder::where('type', 0)->get();
        } else {
            $orders = PlacedOrder::whereDate('created_at', Carbon::today())->where('type', 0)->get();
        }
        return view('reports.general.partials.index', compact('orders'));
    }
}
