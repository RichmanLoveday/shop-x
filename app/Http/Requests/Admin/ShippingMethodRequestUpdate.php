<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShippingMethodRequestUpdate extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'code' => [
                'required',
                'string',
                'max:100',
                'alpha_dash',
                Rule::unique('shipping_methods', 'code')
                    ->ignore($this->route('shipping_method')),
            ],
            'min_days' => [
                'required',
                'integer',
                'min:0',
            ],
            'max_days' => [
                'required',
                'integer',
                'min:0',
                'gte:min_days',
            ],
            'is_active' => [
                'nullable',
                'boolean',
            ],
        ];
    }

    /**
     * Get custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The shipping method name is required.',
            'code.required' => 'The shipping method code is required.',
            'code.alpha_dash' => 'The shipping method code may only contain letters, numbers, dashes and underscores.',
            'code.unique' => 'This shipping method code is already in use.',
            'min_days.required' => 'The minimum delivery days is required.',
            'min_days.integer' => 'The minimum delivery days must be a whole number.',
            'min_days.min' => 'The minimum delivery days cannot be negative.',
            'max_days.required' => 'The maximum delivery days is required.',
            'max_days.integer' => 'The maximum delivery days must be a whole number.',
            'max_days.min' => 'The maximum delivery days cannot be negative.',
            'max_days.gte' => 'The maximum delivery days must be greater than or equal to the minimum delivery days.',
            'is_active.boolean' => 'The active status must be either true or false.',
        ];
    }
}