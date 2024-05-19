<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Jobs\DeleteUnusedTags;


class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query();

        if ($request->has('query')) {
            $query->where('title', 'like', '%' . $request->input('query') . '%');
        }

        if ($request->has('startTime') && $request->has('endTime')) {
            $query->whereBetween('createdAt', [$request->input('startTime'), $request->input('endTime')]);
        }

        if ($request->has('sortBy') && $request->input('sortBy') === 'created_at') {
            $query->orderBy('createdAt', 'desc');
        }

        $categories = $query->paginate(10);

        return response()->json($categories);
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        if (empty($data['metaTitle'])) {
            $data['metaTitle'] = $data['title'];
        }

        $category = Category::create($data);
        return response()->json($category, 201);
    }

    public function update(CategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        $data = $request->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        if (empty($data['metaTitle'])) {
            $data['metaTitle'] = $data['title'];
        }

        $category->update($data);
        return response()->json($category);
    }
    public function show($id)
    {
        $category = Category::with('posts')->findOrFail($id); // Assuming category has a relationship with posts
        return response()->json($category);
    }



    public function destroy($id)
    {
        // $category = Category::findOrFail($id);
        // $category->delete();

        // return response()->json(null, 204);

        $category = Category::findOrFail($id);
        $category->delete();

        DeleteUnusedTags::dispatch();

        return response()->json(null, 204);
    }
}
