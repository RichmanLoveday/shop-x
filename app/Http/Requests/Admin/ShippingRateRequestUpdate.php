<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShippingRateRequestUpdate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'store_id' => [
                'required',
                'integer',
                'exists:stores,id',
            ],
            'shipping_method_id' => [
                'required',
                'integer',
                'exists:shipping_methods,id',
            ],
            'origin_zone_id' => [
                'required',
                'integer',
                'exists:shipping_zones,id',
            ],
            'destination_zone_id' => [
                'required',
                'integer',
                'exists:shipping_zones,id',
                Rule::unique('shipping_rates', 'destination_zone_id')
                    ->where('store_id', $this->store_id)
                    ->where('shipping_method_id', $this->shipping_method_id)
                    ->where('origin_zone_id', $this->origin_zone_id)
                    ->ignore($this->route('shipping_rate')),
            ],
            'min_order_amount' => [
                'required',
                'numeric',
                'min:0',
            ],
            'max_order_amount' => [
                'nullable',
                'numeric',
                'min:0',
                'gte:min_order_amount',
            ],
            'charge' => [
                'required',
                'numeric',
                'min:0',
            ],
            'is_active' => [
                'nullable',
                'boolean',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'destination_zone_id.unique' =>
                'A shipping rate already exists for this vendor, shipping method, origin zone, and destination zone.',
        ];
    }

    public function attributes(): array
    {
        return [
            'store_id' => 'vendor',
            'shipping_method_id' => 'shipping method',
            'origin_zone_id' => 'origin zone',
            'destination_zone_id' => 'destination zone',
            'min_order_amount' => 'minimum order amount',
            'max_order_amount' => 'maximum order amount',
            'is_active' => 'active status',
        ];
    }
}