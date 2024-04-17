<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $data = Category::all();
        return view('category.index', compact('data'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product' => 'required|string',
            'category_name' => 'required|string',
        ]);
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        } else {
            try {
                $newCat = new Category();
                $newCat->product = $request->product;
                $newCat->category_name = $request->category_name;
                $newCat->save();
                return redirect()->back()->with('success', 'New category successfully created!');
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
            'product' => 'required|string',
            'category_name' => 'required|string',
        ]);

        $category = Category::findOrFail($id);

        if (Auth::user()->role == 'admin') {
            $category->update([
                'product' => $request->product,
                'category_name' => $request->category_name,
            ]);

            return redirect()->route('admin.category.index')->with('success', 'category successfully updated!');
        } else {
            return redirect()->back()->with('error', 'Unauthorized action!');
        }
    }

    public function delete($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            return redirect()->back()->with('success', 'category successfully deleted!');
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'msg' => $th->getMessage(),
            ]);
        }
    }
}
