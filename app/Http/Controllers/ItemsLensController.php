<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Lens;
use App\Models\LensPower;

class ItemsLensController extends Controller
{
    public function index()
    {
        $data = Lens::all();
        return view('items.lens.index', compact('data'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mark_lens' => 'required|string',
            'lens_attribute' => 'required|string',
            'sph' => 'required|string',
            'syl' => 'required|string',
            'axis' => 'required|string',
            'add_' => 'required|string',
            'price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        try {
            // Create a new LensPower record
            $lensPower = new LensPower();
            $lensPower->sph = $request->sph;
            $lensPower->syl = $request->syl;
            $lensPower->axis = $request->axis;
            $lensPower->add_ = $request->add_;
            $lensPower->save();

            $newItem = new Lens();
            $newItem->mark_lens = $request->mark_lens;
            $newItem->lens_attribute = $request->lens_attribute;
            $newItem->price = $request->price;
            $newItem->lens_power = $lensPower->id;
            $newItem->save();

            return redirect()->back()->with('success', 'New Item successfully created!');
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'msg' => $th->getMessage(),
            ]);
        }
    }

    public function edit($id)
    {
        $item = Lens::findOrFail($id);
        $powers = \App\Models\Power::get(); 
        $categories = \App\Models\Category::where('product', 2)->get();
        return view('items.lens.edit', compact('item', 'categories', 'powers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'mark_lens' => 'required|string',
            'lens_attribute' => 'required|string',
            'sph' => 'nullable|string',
            'syl' => 'nullable|string',
            'axis' => 'nullable|string',
            'add_' => 'nullable|string',
            'price' => 'required|numeric',
        ]);

        $item = Lens::findOrFail($id);

        if (Auth::user()->role == 'admin') {
            // Update the LensPower record
            try {
                $lensPower = LensPower::findOrFail($item->lens_power);
                $lensPower->update([
                    'sph' => $request->sph,
                    'syl' => $request->syl,
                    'axis' => $request->axis,
                    'add_' => $request->add_,
                ]);
            } catch (\Throwable $th) {
                return redirect()
                    ->back()
                    ->with('error', 'Failed to update Lens Power: ' . $th->getMessage());
            }

            // Update the Lens item
            $item->update([
                'mark_lens' => $request->mark_lens,
                'lens_attribute' => $request->lens_attribute,
                'price' => $request->price,
            ]);

            return redirect()->route('admin.items.lens.index')->with('success', 'Lens item and associated Lens Power successfully updated!');
        } else {
            return redirect()->back()->with('error', 'Unauthorized action!');
        }
    }

    public function delete($id)
    {
        try {
            $item = Lens::findOrFail($id);
            $item->delete();
            return redirect()->back()->with('success', 'item successfully deleted!');
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'msg' => $th->getMessage(),
            ]);
        }
    }
}
