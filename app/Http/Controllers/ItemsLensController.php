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
            'type_name' => 'required|integer',
            'lens_attribute' => 'required|string',
            'sph' => 'nullable|string',
            'syl' => 'nullable|string',
            'axis' => 'nullable|string',
            'add_' => 'nullable|string',
            'price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        try {
            $newItem = new Lens();
            $newItem->mark_lens = $request->mark_lens;
            $newItem->item_type = $request->type_name;
            $newItem->lens_attribute = $request->lens_attribute;
            $newItem->price = $request->price;
            $newItem->power_sph = $request->sph;
            $newItem->power_cyl = $request->syl;
            $newItem->power_axis = $request->axis;
            $newItem->power_add = $request->add_;
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
        $attributes = \App\Models\Attribute::get();
        $types = \App\Models\Type::where('status', true)
        ->where('product_category', 2)
        ->get();
        return view('items.lens.edit', compact('item', 'categories', 'attributes', 'powers', 'types'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'mark_lens' => 'required|string',
            'type_name' => 'required|integer',
            'lens_attribute' => 'required|string',
            'sph' => 'nullable|string',
            'syl' => 'nullable|string',
            'axis' => 'nullable|string',
            'add_' => 'nullable|string',
            'price' => 'required|numeric',
        ]);

        $item = Lens::findOrFail($id);

        if (Auth::user()->role == 'admin') {

            // Update the Lens item
            $item->update([
                'mark_lens' => $request->mark_lens,
                'power_sph' => $request->sph,
                'power_cyl' => $request->syl,
                'power_axis' => $request->axis,
                'power_add' => $request->add_,
                'item_type' => $request->type_name,
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
