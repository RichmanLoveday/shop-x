<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BrandRequestCreate extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'brand_logo' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'is_active' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please enter brand name',
            'name.string' => 'Brand name must be a valid string',
            'name.max' => 'Brand name must not exceed 255 characters',
            'brand_logo.required' => 'Please upload a brand logo',
            'brand_logo.image' => 'Brand logo must be an image',
            'brand_logo.mimes' => 'Brand logo must be a file of type: jpeg, png, jpg',
            'brand_logo.max' => 'Brand logo size must not exceed 2MB',
            'is_active.boolean' => 'Active status must be true or false',
        ];
    }
}