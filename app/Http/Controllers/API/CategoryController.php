<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query();

        // Filter by startTime and endTime 
        if ($request->has('startTime') && $request->has('endTime')) {
            $query->whereBetween('created_at', [$request->input('startTime'), $request->input('endTime')]);
        }

        // Sort by created_at 
        if ($request->has('sortBy') && $request->input('sortBy') === 'created_at') {
            $query->orderBy('created_at', 'desc');
        }

        // Paginate 
        $categories = $query->paginate(10);

        return response()->json($categories);
    }

    public function store(Request $request)
    {
        // Validate 
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Create 
        $category = Category::create($validatedData);

        return response()->json($category, 201);
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }


    public function update(Request $request, $id)
    {
        // Validate 
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'description' => 'string',
        ]);

        $category = Category::findOrFail($id);

        // Update 
        $category->update($validatedData);

        return response()->json($category, 200);
    }


    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json(null, 204);
    }
}
