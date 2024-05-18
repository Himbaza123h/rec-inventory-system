<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Insurance;

class InsuranceController extends Controller
{
    public function index()
    {
        $insurances = Insurance::where('status', true)->get();
        return view('admin.insurances.index', compact('insurances'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'insurance_name' => 'required|string',
        ]);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        try {
            $newItem = new Insurance();
            $newItem->insurance_name = $request->insurance_name;
            $newItem->save();

            return redirect()->back()->with('success', 'New insurance successfully created!');
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'msg' => $th->getMessage(),
            ]);
        }
    }

    public function delete($id)
    {
        try {
            $data = Insurance::findOrFail($id);
            $data->status = false;
            $data->update();
            return redirect()->back()->with('success', 'insurance successfully removed!');
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'msg' => $th->getMessage(),
            ]);
        }
    }
}
