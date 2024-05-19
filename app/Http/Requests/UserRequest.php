<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'firstName' => 'required|string|max:50',
            'middleName' => 'nullable|string|max:50',
            'lastName' => 'required|string|max:50',
            'mobile' => 'required|string|max:15',
            'email' => 'required|email|unique:users,email|max:50',
            'passwordHash' => 'required|string|max:32',
            'intro' => 'nullable|string',
            'profile' => 'required|string',
        ];
    }
}
