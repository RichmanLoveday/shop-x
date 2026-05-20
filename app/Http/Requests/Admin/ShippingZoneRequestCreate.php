<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ShippingZoneRequestCreate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'city_ids' => [
                'required',
                'array',
                'min:1',
            ],
            'city_ids.*' => [
                'integer',
                'exists:cities,id',
            ],
            'shipping_rule_ids' => [
                'required',
                'array',
                'min:1',
            ],
            'shipping_rule_ids.*' => [
                'integer',
                'exists:shipping_rules,id',
            ],
            'is_active' => [
                'nullable',
                'boolean',
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Zone name is required.',
            'state_id.required' => 'Please select a state.',
            'city_ids.required' => 'Select at least one city.',
            'shipping_rule_ids.required' => 'Select at least one shipping rule.',
        ];
    }
}