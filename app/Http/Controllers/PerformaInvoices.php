<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CartLens;
class PerformaInvoices extends Controller
{
    public function glass()
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            $invoices = CartItem::where('status', 3)->distinct('sale_code')->get();
        } else {
            $invoices = CartItem::where('status', 3)
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->distinct('sale_code')
                ->get();
        }

        $data = null;
        return view('invoices.proforma.glass.index', compact('invoices', 'data'));
    }

    public function GlassbySellCode($id = null)
    {
        $invoices = CartItem::where('');

        $data = null;

        if ($id) {
            $data = CartItem::where('sale_code', $id)->get();
        }

        return view('invoices.general.index', compact('data', 'invoices'));
    }

    public function lens()
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            $invoices = CartLens::where('status', 3)->distinct('sale_code')->get();
        } else {
            $invoices = CartLens::where('status', 3)
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->distinct('sale_lens_code')
                ->get();
        }

        $data = null;
        return view('invoices.proforma.lens.index', compact('invoices', 'data'));
    }

    public function LensbySellCode($id)
    {
    }
}
