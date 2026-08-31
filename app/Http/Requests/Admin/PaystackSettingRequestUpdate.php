<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaystackSettingRequestUpdate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'paystack_status' => ['required', Rule::in(['active', 'inactive'])],
            'paystack_mode' => ['required', Rule::in(['sandbox', 'live'])],
            'paystack_country' => ['required', 'string', 'max:10'],
            'paystack_currency_rate' => ['required', 'numeric', 'min:0'],
            'paystack_public_key' => ['required', 'string', 'max:255'],
            'paystack_secret_key' => ['required', 'string', 'max:255'],
            'paystack_webhook_url' => ['nullable', 'url', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'paystack_status.required' => 'Paystack status is required.',
            'paystack_status.in' => 'Status must be active or inactive.',
            'paystack_mode.required' => 'Paystack mode is required.',
            'paystack_mode.in' => 'Mode must be sandbox or live.',
            'paystack_country.required' => 'Please select a country.',
            'paystack_currency_rate.required' => 'Currency rate is required.',
            'paystack_currency_rate.numeric' => 'Currency rate must be a valid number.',
            'paystack_currency_rate.min' => 'Currency rate cannot be negative.',
            'paystack_public_key.required' => 'Public key is required.',
            'paystack_secret_key.required' => 'Secret key is required.',
            'paystack_webhook_url.url' => 'Webhook must be a valid URL.',
        ];
    }
}