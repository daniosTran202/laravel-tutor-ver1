<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'parentId' => 'required|exists:categories,id',
            'title' => 'required|string|max:75',
            'metaTitle' => 'required|string|max:100',
            'slug' => 'required|string|max:100',
            'content' => 'required|string',
        ];
    }
}
