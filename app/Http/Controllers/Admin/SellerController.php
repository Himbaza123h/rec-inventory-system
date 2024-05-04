<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seller;
use Illuminate\Support\Facades\Validator;

class SellerController extends Controller
{
    public function index()
    {
        $data = Seller::where('status', true)->get();
        return view('admin.sellers.index', compact('data'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'seller_name' => 'required|string|unique:sellers,seller_name',
            'seller_phone' => 'nullable|string|regex:/^07\d{8}$/|min:10|max:10|unique:sellers,seller_phone',
        ]);
    
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        } else {
            try {
                $newSeller = new Seller();
                $newSeller->seller_name = $request->seller_name;
                $newSeller->seller_phone = $request->seller_phone;
                $newSeller->save();
                return redirect()->back()->with('success', 'New Seller successfully added!');
            } catch (\Throwable $th) {
                return response()->json([
                    'status' => 'error',
                    'msg' => $th->getMessage(),
                ]);
            }
        }
    }




    public function edit($id)
    {
        $data = Seller::findOrFail($id);

        return view('admin.sellers.create', compact('data'));
    }
    


    public function update(Request $request, $id)
    {
        // Find the seller by ID
        $seller = Seller::findOrFail($id);
    
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'seller_name' => 'required|string|unique:sellers,seller_name,'.$seller->id,
            'seller_phone' => 'nullable|string|regex:/^07\d{8}$/|min:10|max:10|unique:sellers,seller_phone,'.$seller->id,
        ]);
    
        // If validation fails, redirect back with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Update seller data with new values
        if ($request->has('seller_name')) {
            $seller->seller_name = $request->input('seller_name');
        }
    
        if ($request->has('seller_phone')) {
            $seller->seller_phone = $request->input('seller_phone');
        }
    
        $seller->save();
    
        // Redirect to a success page or route
        return redirect()
            ->route('admin.sellers.index')
            ->with('success', 'Seller updated successfully.');
    }
    



    public function delete($id)
    {
        try {
            $seller = Seller::findOrFail($id);
            $seller->status = false;
            $seller->update();
            return redirect()->back()->with('success', 'Seller removed successfully!');
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'msg' => $th->getMessage(),
            ]);
        }
    }
}
