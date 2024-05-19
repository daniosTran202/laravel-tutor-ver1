<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'authorId' => 'required|exists:users,id',
            'parentId' => 'required|exists:categories,id',
            'title' => 'required|string|max:75',
            'metaTitle' => 'required|string|max:100',
            'slug' => 'required|string|max:100',
            'summary' => 'required|string',
            'published' => 'required|boolean',
            'content' => 'required|string',
        ];
    }
}
