<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\TagRequest;
use App\Models\Tag;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TagController extends Controller
{
    public function index(Request $request)
    {
        // $query = Tag::query();

        // if ($request->has('query')) {
        //     $query->where('title', 'like', '%' . $request->input('query') . '%');
        // }

        // $tags = $query->paginate(10);

        // return response()->json($tags);

        $tags = Cache::remember('tags', 60, function () use ($request) {
            $query = Tag::query();

            if ($request->has('query')) {
                $query->where('title', 'like', '%' . $request->input('query') . '%');
            }

            return $query->paginate(10);
        });

        return response()->json($tags);
    }

    public function store(TagRequest $request)
    {
        $data = $request->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        if (empty($data['metaTitle'])) {
            $data['metaTitle'] = $data['title'];
        }

        $tag = Tag::create($data);
        Cache::forget('tags');

        return response()->json($tag, 201);
    }
}
