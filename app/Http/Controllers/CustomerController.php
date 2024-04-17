<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class CustomerController extends Controller
{
    public function index()
    {
        $data = Customer::all();
        return view('admin.users.customers.index', compact('data'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string',
            'customer_tin_number' => 'required|string',
            'customer_phone' => 'required|string',
            'customer_address' => 'required|string',
        ]);
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        } else {
            try {
                $new = new Customer();
                $new->customer_name = $request->customer_name;
                $new->customer_tin_number = $request->customer_tin_number;
                $new->customer_phone = $request->customer_phone;
                $new->customer_address = $request->customer_address;
                $new->save();
                return redirect()->back()->with('success', 'New Customer successfully added!');
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
            'customer_name' => 'required|string',
            'customer_tin_number' => 'required|string',
            'customer_phone' => 'required|string',
            'customer_address' => 'required|string',
        ]);

        $category = Customer::findOrFail($id);

        if (Auth::user()->role == 'admin') {
            $category->update([
                'customer_name' => $request->customer_name,
                'customer_tin_number' => $request->customer_tin_number,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
            ]);

            return redirect()->route('admin.items.index')->with('success', 'customer successfully updated!');
        } else {
            return redirect()->back()->with('error', 'Unauthorized action!');
        }
    }

    public function delete($id)
    {
        try {
            $data = Customer::findOrFail($id);
            $data->delete();
            return redirect()->back()->with('success', 'customer successfully deleted!');
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'msg' => $th->getMessage(),
            ]);
        }
    }
}
