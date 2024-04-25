<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Color;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::all();

        return view('admin.colors.index', compact('colors'));
    }

    public function edit($id)
    {
        $color = Color::findOrFail($id);

        return view('admin.colors.edit', compact('color'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'color_name' => 'required|string',
        ]);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        } else {
            try {
                // Check if category_name already exists
                $existingColor = Color::where('color_name', $request->color_name)->first();

                if ($existingColor) {
                    return redirect()->back()->with('error', 'Color code already exists.');
                }

                // If category_name doesn't exist, create a new category
                $newColor = new Color();
                $newColor->color_name = $request->color_name;
                $newColor->save();
                return redirect()->back()->with('success', 'New Color successfully created!');
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
            'color_name' => 'required|string',
        ]);

        $category = Color::findOrFail($id);

        if (Auth::user()->role == 'admin') {
            $category->update([
                'color_name' => $request->color_name,
            ]);

            return redirect()->route('admin.colors.index')->with('success', 'color successfully updated!');
        } else {
            return redirect()->back()->with('error', 'Unauthorized action!');
        }
    }

    public function delete($id)
    {
        try {
            $color = Color::findOrFail($id);
            $color->delete();
            return redirect()->back()->with('success', 'color successfully deleted!');
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'msg' => $th->getMessage(),
            ]);
        }
    }
}
