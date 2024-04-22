<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    public function index()
    {
        $data = Supplier::all();
        return view('admin.users.suppliers.index', compact('data'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplier_name' => 'required|string',
            'supplier_tin_number' => 'required|string',
            'supplier_phone' => 'nullable|string|min:10|max:10|regex:/^07\d{8}$/',
            'supplier_email' => 'required|email|unique:suppliers',
            'supplier_work_place' => 'required|string',
        ]);
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        } else {
            try {
                $new = new Supplier();
                $new->supplier_name = $request->supplier_name;
                $new->supplier_tin_number = $request->supplier_tin_number;
                $new->supplier_phone = $request->supplier_phone;
                $new->supplier_email = $request->supplier_email;
                $new->supplier_work_place = $request->supplier_work_place;
                $new->save();
                return redirect()->back()->with('success', 'New Supplier successfully added!');
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
        $user = Supplier::findOrFail($id);

        return view('admin.users.suppliers.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'supplier_name' => 'required|string',
            'supplier_tin_number' => 'required|string',
            'supplier_phone' => 'nullable|string|min:10|max:10|regex:/^07\d{8}$/',
            'supplier_email' => 'required|email',
            'supplier_work_place' => 'required|string',
        ]);

        // If validation fails, redirect back with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Find the customer by ID
        $supplier = Supplier::findOrFail($id);

        // Update customer data with new values
        $supplier->supplier_name = $request->input('supplier_name');
        $supplier->supplier_tin_number = $request->input('supplier_tin_number');
        $supplier->supplier_phone = $request->input('supplier_phone');
        $supplier->supplier_email = $request->input('supplier_email');
        $supplier->supplier_work_place = $request->input('supplier_work_place');
        $supplier->save();

        // Redirect to a success page or route
        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier updated successfully.');
    }

    public function delete($id)
    {
        try {
            $data = Supplier::findOrFail($id);
            $data->delete();
            return redirect()->back()->with('success', 'supplier successfully deleted!');
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'msg' => $th->getMessage(),
            ]);
        }
    }
}
