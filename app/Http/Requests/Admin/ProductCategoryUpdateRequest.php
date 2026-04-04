<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductCategoryUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->route('id');

        return [
            'name' => ['required', 'string', 'max:255'],
            // 'slug' => [
            //     'required',
            //     'string',
            //     'max:255',
            //     Rule::unique('categories', 'slug')->ignore($categoryId),
            // ],
            'parent_id' => [
                'nullable',
                'exists:categories,id',
            ],
            'is_active' => [
                'required',
                'boolean',
            ],
        ];
    }
}