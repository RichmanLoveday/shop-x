<?php

namespace App\Http\Requests\Admin;

use App\Enums\ProductAttributeType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductAttributeStoreRequest extends FormRequest
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
            'attribute_id' => ['nullable', 'integer', 'exists:attributes,id'],
            'attribute_name' => ['required', 'string', 'max:255'],
            'attribute_type' => ['required', Rule::enum(ProductAttributeType::class)],
            'label' => ['required', 'array', 'min:1'],
            'label.*' => ['required', 'string'],
            'color_value' => ['nullable', 'array'],
            'color_value.*' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'attribute_name.required' => 'The attribute name is required.',
            'attribute_name.string' => 'The attribute name must be a string.',
            'attribute_name.max' => 'The attribute name may not be greater than 255 characters.',
            'attribute_type.required' => 'The attribute type is required.',
            'attribute_type.enum' => 'The selected attribute type is invalid.',
            'label.required' => 'At least one label is required.',
            'label.array' => 'The label must be an array.',
            'label.*.required' => 'Each label is required.',
            'label.*.string' => 'Each label must be a string.',
            'color_value.array' => 'The color value must be an array.',
            'color_value.*.string' => 'Each color value must be a string.',
        ];
    }
}
