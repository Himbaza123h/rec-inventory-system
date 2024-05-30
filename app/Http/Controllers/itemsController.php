<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Lens;
use App\Models\Color;
use App\Models\Attribute;
use App\Models\Type;

class itemsController extends Controller
{
    public function index()
    {
        $data = Item::where('status', true)->where('product_category', 1)->get();
        return view('items.glasses.index', compact('data'));
    }

    public function index2()
    {
        $data = Item::where('status', true)->where('product_category', 3)->get();
        return view('items.glasses.sun.index', compact('data'));
    }

    public function index3()
    {
        $data = Item::where('status', true)->where('product_category', 4)->get();
        return view('items.glasses.reading.index', compact('data'));
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
            'type_name' => 'required|integer',
            'code_id' => 'required|string',
            'product_type' => 'required|integer',
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
                $newItem->item_type = $request->type_name;
                $newItem->code_id = $request->code_id;
                $newItem->product_category = $request->product_type;
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
            'type_name' => 'required|integer',
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
                'item_type' => $request->type_name,
                'code_id' => $request->code_id,
                'lens_width' => $request->lens_width,
                'bridge_width' => $request->bridge_width,
                'temple_length' => $request->temple_length,
                'color_id' => $request->color_id,
                'price' => $request->price,
            ]);

            return redirect()->back()->with('success', 'Item successfully updated!'); // Corrected success message
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

    public function getTypes(Request $request)
    {
        $brandId = $request->input('brand_id');
        $typeIds = Item::where('product_category', 1)->where('mark_glasses', $brandId)->pluck('item_type', 'id')->unique();
        $types = Type::whereIn('id', $typeIds)->get();
        return response()->json($types);
    }

    public function getCodes(Request $request)
    {
        $brandId = $request->input('brand_id');
        $typeId = $request->input('type_id');
        $codes = Item::where('product_category', 1)->where('mark_glasses', $brandId)->where('item_type', $typeId)->pluck('code_id')->unique();
        return response()->json($codes);
    }

    public function getColors(Request $request)
    {
        $brandId = $request->input('brand_id');
        $codeId = $request->input('code_id');
        $typeId = $request->input('type_id');
        $colorIds = Item::where('product_category', 1)->where('mark_glasses', $brandId)->where('item_type', $typeId)->where('code_id', $codeId)->pluck('color_id')->unique();
        $colors = Color::whereIn('id', $colorIds)->get();
        return response()->json($colors);
    }

   public function getSizes(Request $request)
    {
        $brandId = $request->input('brand_id');
        $codeId = $request->input('code_id');
        $typeId = $request->input('type_id');
        $colorId = $request->input('color_id');

        $items = Item::where('product_category', 1)
            ->where('mark_glasses', $brandId)
            ->where('item_type', $typeId)
            ->where('code_id', $codeId)
            ->where('color_id', $colorId)
            ->get(['lens_width', 'bridge_width', 'temple_length']);

        $sizes = $items->map(function ($item) {
            return $item->lens_width . ' - ' . $item->bridge_width . ' - ' . $item->temple_length;
        });

        return response()->json($sizes);
    }



    public function getAttributes(Request $request)
    {
        $category_id = $request->category_id;
        $attributeIds = Lens::where('mark_lens', $category_id)->pluck('lens_attribute')->unique();
        $attributes = Attribute::whereIn('id', $attributeIds)->get();
        return response()->json($attributes);
    }

    public function getSph(Request $request)
    {
        $category_id = $request->category_id;
        $attribute_id = $request->attribute_id;

        $sphValues = Lens::where('mark_lens', $category_id)->where('lens_attribute', $attribute_id)->pluck('power_sph')->unique()->filter()->toArray();

        return response()->json($sphValues);
    }

    public function getCyl(Request $request)
    {
        $category_id = $request->category_id;
        $attribute_id = $request->attribute_id;

        $cylValues = Lens::where('mark_lens', $category_id)->where('lens_attribute', $attribute_id)->pluck('power_cyl')->unique()->filter()->toArray();

        return response()->json($cylValues);
    }

    public function getAxis(Request $request)
    {
        $category_id = $request->category_id;
        $attribute_id = $request->attribute_id;

        $axisValues = Lens::where('mark_lens', $category_id)->where('lens_attribute', $attribute_id)->pluck('power_axis')->unique()->filter()->toArray();

        return response()->json($axisValues);
    }

    public function getAdd(Request $request)
    {
        $category_id = $request->category_id;
        $attribute_id = $request->attribute_id;

        $addValues = Lens::where('mark_lens', $category_id)->where('lens_attribute', $attribute_id)->pluck('power_add')->unique()->filter()->toArray();

        return response()->json($addValues);
    }

    // Handling Sunglasses

    public function getTypes3(Request $request)
    {
        $brandId = $request->input('brand_id');
        $typeIds = Item::where('product_category', 3)->where('mark_glasses', $brandId)->pluck('item_type', 'id')->unique();
        $types = Type::whereIn('id', $typeIds)->get();
        return response()->json($types);
    }

    public function getCodes3(Request $request)
    {
        $brandId = $request->input('brand_id');
        $typeId = $request->input('type_id');
        $codes = Item::where('product_category', 3)->where('mark_glasses', $brandId)->where('item_type', $typeId)->pluck('code_id')->unique();
        return response()->json($codes);
    }

    public function getColors3(Request $request)
    {
        $brandId = $request->input('brand_id');
        $codeId = $request->input('code_id');
        $typeId = $request->input('type_id');
        $colorIds = Item::where('product_category', 3)->where('mark_glasses', $brandId)->where('item_type', $typeId)->where('code_id', $codeId)->pluck('color_id')->unique();
        $colors = Color::whereIn('id', $colorIds)->get();
        return response()->json($colors);
    }

    public function getSizes3(Request $request)
    {
        $brandId = $request->input('brand_id');
        $codeId = $request->input('code_id');
        $typeId = $request->input('type_id');
        $colorId = $request->input('color_id');

        $items = Item::where('product_category', 4)
            ->where('mark_glasses', $brandId)
            ->where('item_type', $typeId)
            ->where('code_id', $codeId)
            ->where('color_id', $colorId)
            ->get(['lens_width', 'bridge_width', 'temple_length']);

        $sizes = $items->map(function ($item) {
            return $item->lens_width . ' - ' . $item->bridge_width . ' - ' . $item->temple_length;
        });

        return response()->json($sizes);
    }

    // Handling Sunglasses

    public function getTypes4(Request $request)
    {
        $brandId = $request->input('brand_id');
        $typeIds = Item::where('product_category', 4)->where('mark_glasses', $brandId)->pluck('item_type', 'id')->unique();
        $types = Type::whereIn('id', $typeIds)->get();
        return response()->json($types);
    }

    public function getCodes4(Request $request)
    {
        $brandId = $request->input('brand_id');
        $typeId = $request->input('type_id');
        $codes = Item::where('product_category', 4)->where('mark_glasses', $brandId)->where('item_type', $typeId)->pluck('code_id')->unique();
        return response()->json($codes);
    }

    public function getColors4(Request $request)
    {
        $brandId = $request->input('brand_id');
        $codeId = $request->input('code_id');
        $typeId = $request->input('type_id');
        $colorIds = Item::where('product_category', 4)->where('mark_glasses', $brandId)->where('item_type', $typeId)->where('code_id', $codeId)->pluck('color_id')->unique();
        $colors = Color::whereIn('id', $colorIds)->get();
        return response()->json($colors);
    }

    public function getSizes4(Request $request)
    {
        $brandId = $request->input('brand_id');
        $codeId = $request->input('code_id');
        $typeId = $request->input('type_id');
        $colorId = $request->input('color_id');

        $items = Item::where('product_category', 4)
            ->where('mark_glasses', $brandId)
            ->where('item_type', $typeId)
            ->where('code_id', $codeId)
            ->where('color_id', $colorId)
            ->get(['lens_width', 'bridge_width', 'temple_length']);

        $sizes = $items->map(function ($item) {
            return $item->lens_width . ' - ' . $item->bridge_width . ' - ' . $item->temple_length;
        });

        return response()->json($sizes);
    }
}
