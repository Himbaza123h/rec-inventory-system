<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;

class ManageUsersController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'role' => 'required|string',
            'phone' => 'nullable|string|regex:/^07\d{8}$/|min:10|max:10',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        } else {
            try {
                $newUser = new User();
                $newUser->name = $request->name;
                $newUser->email = $request->email;
                $newUser->phone = $request->phone;
                $newUser->role = $request->role;
                $newUser->approved = 1;
                $newUser->password = bcrypt($request->password);
                $newUser->save();
                return redirect()->back()->with('success', 'New User successfully added!');
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
        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|min:10|max:10|regex:/^07\d{8}$/',
            'role' => 'required|in:admin,seller',
            'status' => 'required|in:0,1', // Change to 'status' instead of 'approved'
            'password' => 'nullable|string|min:6',
        ]);

        // If validation fails, redirect back with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Find the user by ID
        $user = User::findOrFail($id);

        // Update user data with new values
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->role = $request->input('role');
        $user->approved = $request->input('status');

        // Check if a new password is provided and update it
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        // Save the updated user data
        $user->save();

        // Redirect to a success page or route
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function delete($id)
    {
        try {
            $data = User::findOrFail($id);
            $data->delete();
            return redirect()->back()->with('success', 'user successfully deleted!');
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'msg' => $th->getMessage(),
            ]);
        }
    }
}
