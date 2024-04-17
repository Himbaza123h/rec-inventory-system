<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->approved == 1) {
            if (Auth::user()->role == 'admin') {
                $data = [];
                return view('admin.index', compact('data'));
            } elseif (Auth::user()->role == 'seller') {
                $data = [];
            }
            return view('seller.index', compact('data'));
        } else {
            return back();
        }
    }
}
