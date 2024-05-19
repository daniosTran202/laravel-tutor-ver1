<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:75',
            'metaTitle' => 'required|string|max:100',
            'slug' => 'required|string|max:100',
            'content' => 'required|string'
        ];
    }
}
