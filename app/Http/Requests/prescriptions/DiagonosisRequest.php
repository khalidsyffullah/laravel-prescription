<?php

namespace App\Http\Requests\prescriptions;

use Illuminate\Foundation\Http\FormRequest;

class DiagonosisRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Set to true to allow authorization
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'descriptions' => 'nullable|string',
        ];
    }
}
