<?php

namespace App\Http\Requests\Admin;

use App\Enums\ShippingRulesType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShippingRuleRequestCreate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'type' => [
                'required',
                Rule::in(array_column(ShippingRulesType::cases(), 'value')),
            ],
            'minimum_amount' => [
                'nullable',
                'numeric',
                'min:0',
                Rule::requiredIf(
                    $this->type === ShippingRulesType::MIN_ORDER_AMOUNT->value
                ),
            ],
            'charge' => ['required', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'is_fallback' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Shipping rule name is required.',
            'name.max' => 'Shipping rule name cannot exceed 255 characters.',
            'type.required' => 'Please select a shipping rule type.',
            'type.in' => 'Selected shipping rule type is invalid.',
            'minimum_amount.required' => 'Minimum order amount is required.',
            'minimum_amount.numeric' => 'Minimum order must be a valid number.',
            'minimum_amount.min' => 'Minimum order cannot be less than 0.',
            'charge.required' => 'Shipping charge is required.',
            'charge.numeric' => 'Shipping charge must be a valid number.',
            'charge.min' => 'Shipping charge cannot be less than 0.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);
    }
}