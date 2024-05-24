<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes = Attribute::all();
        return view('admin.attributes.index', compact('attributes'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'attribute_name' => 'required|string|unique:attributes',
        ]);
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        } else {
            try {
                $newCat = new Attribute();
                $newCat->attribute_name = $request->attribute_name;
                $newCat->save();
                return redirect()->back()->with('success', 'New attribute successfully created!');
            } catch (\Throwable $th) {
                return response()->json([
                    'status' => 'error',
                    'msg' => $th->getMessage(),
                ]);
            }
        }
    }

    public function delete($id)
    {
        try {
            $attribute = Attribute::findOrFail($id);
            $attribute->delete();
            return redirect()->back()->with('success', 'attribute successfully deleted!');
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'msg' => $th->getMessage(),
            ]);
        }
    }
}
