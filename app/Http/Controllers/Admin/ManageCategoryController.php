<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class ManageCategoryController extends Controller
{
    public function index()
    {
        $data = Category::all();
        return view('category.index', compact('data'));
    }

    public function edit($id)
    {
        $data = Category::findOrFail($id);
        return view('category.edit', compact('data'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product' => 'required|string',
            'category_name' => 'required|string|unique:categories',
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
            'category_name' => 'required|string|unique:categories',
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
