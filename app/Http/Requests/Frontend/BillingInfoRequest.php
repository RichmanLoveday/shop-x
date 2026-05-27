<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BillingInfoRequest extends FormRequest
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
            'shipping_method_id' => [
                'required',
                'integer',
                Rule::exists('shipping_zone_shipping_rule', 'shipping_rule_id')
                    ->where(function ($query) {
                        $query->where('shipping_zone_id', request('zone_id'));
                    }),
            ],
            'zone_id' => ['required', 'integer', 'exists:shipping_zones,id'],
            'billing_address_id' => ['required', 'integer', 'exists:addresses,id'],
            'shipping_address_id' => ['required', 'integer', 'exists:addresses,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'shipping_method_id.required' => 'Please select a shipping method.',
            'shipping_method_id.integer' => 'Invalid shipping method selected.',
            'shipping_method_id.exists' => 'The selected shipping method is not available for the chosen shipping zone.',
            'zone_id.required' => 'Please select a shipping zone.',
            'zone_id.integer' => 'Invalid shipping zone selected.',
            'zone_id.exists' => 'The selected shipping zone does not exist.',
            'billing_address_id.required' => 'Please select a billing address.',
            'billing_address_id.integer' => 'Invalid billing address selected.',
            'billing_address_id.exists' => 'The selected billing address does not exist.',
            'shipping_address_id.required' => 'Please select a shipping address.',
            'shipping_address_id.integer' => 'Invalid shipping address selected.',
            'shipping_address_id.exists' => 'The selected shipping address does not exist.',
        ];
    }
}
