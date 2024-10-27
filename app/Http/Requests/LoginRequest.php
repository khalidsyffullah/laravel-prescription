<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => 'nullable|email|required_without:phone',
            'phone' => 'nullable|numeric|required_without:email',
            'password' => 'required|string|min:8',
        ];
    }

    public function messages()
    {
        return [
            'email.required_without' => 'Email or phone is required.',
            'phone.required_without' => 'Phone or email is required.',
            'password.required' => 'Password is required.',
        ];
    }
}
