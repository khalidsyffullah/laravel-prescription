<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class patientDetailsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_no' => 'nullable|integer',
            'age' => 'nullable|string|max:255',
            'weight' => 'nullable|numeric',
            'gender' => 'required|in:male,female',
        ];
    }
}