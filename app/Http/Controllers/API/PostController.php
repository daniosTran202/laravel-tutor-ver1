<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;


class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::query();

        // Filter by startTime and endTime 
        if ($request->has('startTime') && $request->has('endTime')) {
            $query->whereBetween('created_at', [$request->input('startTime'), $request->input('endTime')]);
        }

        // Filter by tags 
        if ($request->has('tags')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->whereIn('id', $request->input('tags'));
            });
        }

        // Filter by category 
        if ($request->has('category')) {
            $query->where('category_id', $request->input('category'));
        }

        // Sort by created_at 
        if ($request->has('sortBy') && $request->input('sortBy') === 'created_at') {
            $query->orderBy('created_at', 'desc');
        }

        // Paginate 
        $posts = $query->paginate(10);

        return response()->json($posts);
    }

    public function store(Request $request)
    {
        // Validate 
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'tags' => 'array',
            'category_id' => 'required|exists:categories,id'
        ]);

        // Create 
        $post = Post::create([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'category_id' => $validatedData['category_id']
        ]);

        // Attach tags
        if (isset($validatedData['tags']) && is_array($validatedData['tags'])) {
            $post->tags()->sync($validatedData['tags']);
        }

        return response()->json($post, 201);
    }

    public function show($id)
    {
        $post = Post::with('tags')->findOrFail($id);
        return response()->json($post);
    }

    public function update(Request $request, $id)
    {
        // Validate 
        $validatedData = $request->validate([
            'title' => 'string|max:255',
            'content' => 'string',
            'tags' => 'array',
            'category_id' => 'exists:categories,id'
        ]);

        $post = Post::findOrFail($id);

        // Update 
        $post->update([
            'title' => $validatedData['title'] ?? $post->title,
            'content' => $validatedData['content'] ?? $post->content,
            'category_id' => $validatedData['category_id'] ?? $post->category_id
        ]);

        // Attach 
        if (isset($validatedData['tags']) && is_array($validatedData['tags'])) {
            $post->tags()->sync($validatedData['tags']);
        }

        return response()->json($post, 200);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return response()->json(null, 204);
    }
}
