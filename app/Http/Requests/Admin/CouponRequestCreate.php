<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationRule;

class CouponRequestCreate extends FormRequest
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
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'max:255', 'unique:coupons,code'],
            'value' => ['required', 'numeric', 'min:0.01'],
            'is_percent' => ['required', 'boolean'],
            'minimum_spend' => ['required', 'numeric', 'min:0'],
            'maximum_spend' => ['required', 'numeric', 'min:0'],
            'usage_limit_per_coupon' => ['required', 'integer', 'min:1'],
            'usage_limit_per_customer' => ['required', 'integer', 'min:1'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'code.required' => 'Coupon code is required.',
            'code.unique' => 'This coupon code already exists.',
            'code.max' => 'Coupon code cannot exceed 255 characters.',
            'value.required' => 'Discount value is required.',
            'value.numeric' => 'Discount value must be a valid number.',
            'value.min' => 'Discount value must be greater than zero.',
            'is_percent.required' => 'Please select a discount type.',
            'is_percent.boolean' => 'Invalid discount type selected.',
            'minimum_spend.required' => 'Minimum spend is required.',
            'minimum_spend.numeric' => 'Minimum spend must be a valid amount.',
            'minimum_spend.min' => 'Minimum spend cannot be negative.',
            'maximum_spend.required' => 'Maximum spend is required.',
            'maximum_spend.numeric' => 'Maximum spend must be a valid amount.',
            'maximum_spend.min' => 'Maximum spend cannot be negative.',
            'usage_limit_per_coupon.integer' => 'Coupon usage limit must be a whole number.',
            'usage_limit_per_coupon.required' => 'Coupon usage limit is required.',
            'usage_limit_per_coupon.min' => 'Coupon usage limit must be at least 1.',
            'usage_limit_per_customer.required' => 'Customer usage limit is required.',
            'usage_limit_per_customer.integer' => 'Customer usage limit must be a whole number.',
            'usage_limit_per_customer.min' => 'Customer usage limit must be at least 1.',
            'start_date.required' => 'Start date is required.',
            'start_date.date' => 'Start date must be a valid date.',
            'end_date.required' => 'End date is required.',
            'end_date.date' => 'End date must be a valid date.',
            'end_date.after_or_equal' => 'End date must be after or equal to start date.',
        ];
    }

    /**
     * Optional: normalize values.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
            'is_percent' => $this->boolean('is_percent'),
            'code' => strtoupper(trim($this->code)),
        ]);
    }
}