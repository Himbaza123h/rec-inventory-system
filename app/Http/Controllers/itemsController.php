<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Item;

class itemsController extends Controller
{
    public function index()
    {
        $data = Item::all();
        return view('items.glasses..index', compact('data'));
    }

    public function edit($id)
    {
        $item = Item::findOrFail($id);

        return view('items.glasses.edit', compact('item'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'target_client' => 'required|string',
            'mark_glasses' => 'required|string',
            'code_id' => 'required|string',
            'lens_width' => 'required|numeric',
            'bridge_width' => 'required|numeric',
            'temple_length' => 'required|numeric',
            'color_id' => 'required|string',
            'price' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        } else {
            try {
                $newItem = new Item();
                $newItem->target_client = $request->target_client;
                $newItem->mark_glasses = $request->mark_glasses;
                $newItem->code_id = $request->code_id;
                $newItem->lens_width = $request->lens_width;
                $newItem->bridge_width = $request->bridge_width;
                $newItem->temple_length = $request->temple_length;
                $newItem->color_id = $request->color_id;
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
            'target_client' => 'required|string',
            'mark_glasses' => 'required|string',
            'code_id' => 'required|string',
            'lens_width' => 'required|numeric',
            'bridge_width' => 'required|numeric',
            'temple_length' => 'required|numeric',
            'color_id' => 'required|string',
            'price' => 'required|numeric',
        ]);

        $item = Item::findOrFail($id);

        if (Auth::user()->role == 'admin') {
            $item->update([
                'target_client' => $request->target_client,
                'mark_glasses' => $request->mark_glasses,
                'code_id' => $request->code_id,
                'lens_width' => $request->lens_width,
                'bridge_width' => $request->bridge_width,
                'temple_length' => $request->temple_length,
                'color_id' => $request->color_id,
                'price' => $request->price,
            ]);

            return redirect()->route('admin.items.index')->with('success', 'Item successfully updated!'); // Corrected success message
        } else {
            return redirect()->back()->with('error', 'Unauthorized action!');
        }
    }

    public function delete($id)
    {
        try {
            $item = Item::findOrFail($id);
            $item->delete();
            return redirect()->back()->with('success', 'Item successfully deleted!');
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'msg' => $th->getMessage(),
            ]);
        }
    }
}
