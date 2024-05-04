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
        $data = Customer::where('status', true)->get();
        return view('admin.users.customers.index', compact('data'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string',
            'customer_tin_number' => 'required|string',
            'insurance_id' => 'required|integer',
            'customer_phone' => 'nullable|string|min:10|max:10|regex:/^07\d{8}$/',
            'customer_address' => 'required|string',
        ]);
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        } else {
            try {
                $new = new Customer();
                $new->customer_name = $request->customer_name;
                $new->insurance_id = $request->insurance_id;
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

    public function edit($id)
    {
        $user = Customer::findOrFail($id);

        return view('admin.users.customers.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string',
            'customer_tin_number' => 'required|string',
            'insurance_id' => 'required|integer',
            'customer_phone' => 'nullable|string|min:10|max:10|regex:/^07\d{8}$/',
            'customer_address' => 'required|string',
        ]);

        // If validation fails, redirect back with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Find the customer by ID
        $customer = Customer::findOrFail($id);

        // Update customer data with new values
        $customer->customer_name = $request->input('customer_name');
        $customer->insurance_id = $request->input('insurance_id');
        $customer->customer_tin_number = $request->input('customer_tin_number');
        $customer->customer_phone = $request->input('customer_phone');
        $customer->customer_address = $request->input('customer_address');
        $customer->save();

        // Redirect to a success page or route
        return redirect()
            ->route(auth()->user()->role . '.customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    public function delete($id)
    {
        try {
            $data = Customer::findOrFail($id);
            $data->status = false;
            $data->update();
            return redirect()->back()->with('success', 'customer successfully removed!');
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'msg' => $th->getMessage(),
            ]);
        }
    }
}
