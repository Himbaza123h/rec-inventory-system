<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Sale;
class PdfController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role == 'admin') {
            // Get all sales for the admin
            $sales = Sale::all();
        } else {
            // Get daily sales for other users
            $sales = Sale::whereDate('created_at', now()->toDateString())->get();
        }

        // Pass the sales data within an array
        $pdf = Pdf::loadView('admin.pdf.pdf', ['sales' => $sales]);
        return $pdf->download('funda-product-data.pdf');
    }
}
