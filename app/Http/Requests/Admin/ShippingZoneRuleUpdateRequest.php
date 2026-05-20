<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ShippingZoneRuleUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules.
     */
    public function rules(): array
    {
        return [
            'shipping_rules' => [
                'required',
                'array',
                'min:1',
            ],
            'shipping_rules.*.id' => [
                'required',
                'integer',
                'exists:shipping_rules,id',
            ],
            'shipping_rules.*.override_charge' => [
                'nullable',
                'numeric',
                'min:0',
            ],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'shipping_rules.required' => 'Please provide at least one shipping rule.',
            'shipping_rules.array' => 'Invalid shipping rules format.',
            'shipping_rules.min' => 'At least one shipping rule is required.',
            'shipping_rules.*.id.required' => 'Shipping rule ID is required.',
            'shipping_rules.*.id.exists' => 'One of the selected shipping rules does not exist.',
            'shipping_rules.*.override_charge.numeric' => 'Override charge must be a valid number.',
            'shipping_rules.*.override_charge.min' => 'Override charge cannot be negative.',
        ];
    }
}