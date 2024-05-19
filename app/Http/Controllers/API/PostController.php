<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\Tag;
use App\Jobs\DeleteUnusedTags;

use Illuminate\Support\Facades\DB;


use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::query();

        if ($request->has('query')) {
            $query->where('title', 'like', '%' . $request->input('query') . '%')
                ->orWhere('content', 'like', '%' . $request->input('query') . '%');
        }

        if ($request->has('startTime') && $request->has('endTime')) {
            $query->whereBetween('createdAt', [$request->input('startTime'), $request->input('endTime')]);
        }

        if ($request->has('sortBy') && $request->input('sortBy') === 'created_at') {
            $query->orderBy('createdAt', 'desc');
        }

        if ($request->has('tags')) {
            $tags = explode(',', $request->input('tags'));
            $query->whereHas('tags', function ($q) use ($tags) {
                $q->whereIn('id', $tags);
            });
        }

        if ($request->has('category')) {
            $query->where('categoryId', $request->input('category'));
        }

        $posts = $query->paginate(10);

        return response()->json($posts);
    }

    // public function store(PostRequest $request)
    // {
    //     $data = $request->validated();

    //     if (empty($data['slug'])) {
    //         $data['slug'] = Str::slug($data['title']);
    //     }

    //     if (empty($data['metaTitle'])) {
    //         $data['metaTitle'] = $data['title'];
    //     }

    //     $post = Post::create($data);
    //     return response()->json($post, 201);
    // }

    public function store(PostRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();

            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['title']);
            }

            if (empty($data['metaTitle'])) {
                $data['metaTitle'] = $data['title'];
            }

            $post = Post::create($data);

            if ($request->has('tags')) {
                $tags = [];
                foreach ($request->input('tags') as $tag) {
                    if (is_numeric($tag)) {
                        $tags[] = $tag;
                    } else {
                        $newTag = Tag::create(['title' => $tag]);
                        $tags[] = $newTag->id;
                    }
                }
                $post->tags()->sync($tags);
            }

            DB::commit();
            return response()->json($post, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $data = $request->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        if (empty($data['metaTitle'])) {
            $data['metaTitle'] = $data['title'];
        }

        $post->update($data);
        return response()->json($post);
    }
    public function show($id)
    {
        $post = Post::with(['tags', 'category'])->findOrFail($id);
        return response()->json($post);
    }

    public function destroy($id)
    {
        // $post = Post::findOrFail($id);
        // $post->delete();

        // return response()->json(null, 204);

        $post = Post::findOrFail($id);
        $post->tags()->detach();
        $post->delete();

        DeleteUnusedTags::dispatch();

        return response()->json(null, 204);
    }
}
