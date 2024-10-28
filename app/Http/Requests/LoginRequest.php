<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email_or_phone' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL) &&
                        !is_numeric($value)) {
                        $fail('Please enter a valid email or phone number.');
                    }
                },
            ],
            'password' => 'required|string|min:8',
        ];
    }

    public function messages()
    {
        return [
            'email_or_phone.required' => 'Email or phone is required.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
        ];
    }

    protected function prepareForValidation()
    {
        // Clean the phone number if it's not an email
        if ($this->has('email_or_phone') && !filter_var($this->email_or_phone, FILTER_VALIDATE_EMAIL)) {
            // Remove any non-numeric characters from phone number
            $this->merge([
                'email_or_phone' => preg_replace('/[^0-9]/', '', $this->email_or_phone)
            ]);
        }
    }
}
