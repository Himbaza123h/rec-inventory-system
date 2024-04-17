<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Lens;

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
            'lens_power' => 'required|string',
            'price' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        } else {
            try {
                $newItem = new Lens();
                $newItem->mark_lens = $request->mark_lens;
                $newItem->lens_attribute = $request->lens_attribute;
                $newItem->lens_power = $request->lens_power;
                $newItem->price = $request->price;
                $newItem->save();
                return redirect()->back()->with('success', 'New Item successfully created!');
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
            'mark_lens' => 'required|string',
            'lens_attribute' => 'required|string',
            'lens_power' => 'required|string',
            'price' => 'required|numeric',
        ]);

        $category = Lens::findOrFail($id);

        if (Auth::user()->role == 'admin') {
            $category->update([
                'mark_lens' => $request->mark_lens,
                'lens_attribute' => $request->lens_attribute,
                'lens_power' => $request->lens_power,
                'price' => $request->price,
            ]);

            return redirect()->route('admin.items.lens.index')->with('success', 'item lens successfully updated!');
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
