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
            'supplier_phone' => 'required|string',
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

    public function update(Request $request, $id)
    {
        // Validate the form data
        $request->validate([
            'supplier_name' => 'required|string',
            'supplier_tin_number' => 'required|string',
            'supplier_phone' => 'required|string',
            'supplier_email' => 'required|email|unique:suppliers',
            'supplier_work_place' => 'required|string',
        ]);

        $category = Supplier::findOrFail($id);

        if (Auth::user()->role == 'admin') {
            $category->update([
                'supplier_name' => $request->supplier_name,
                'supplier_tin_number' => $request->supplier_tin_number,
                'supplier_phone' => $request->supplier_phone,
                'supplier_email' => $request->supplier_email,
                'supplier_work_place' => $request->supplier_work_place,
            ]);

            return redirect()->route('admin.items.index')->with('success', 'supplier successfully updated!');
        } else {
            return redirect()->back()->with('error', 'Unauthorized action!');
        }
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
