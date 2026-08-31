<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FlutterwaveSettingRequestUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get validation rules
     */
    public function rules(): array
    {
        return [
            'flutterwave_status' => ['required', Rule::in(['active', 'inactive'])],
            'flutterwave_mode' => ['required', Rule::in(['sandbox', 'live'])],
            'flutterwave_country' => ['required', 'string', 'max:10'],
            'flutterwave_currency_icon' => ['required', 'string', 'max:10'],
            'flutterwave_currency_rate' => ['required', 'numeric', 'min:0'],
            'flutterwave_public_key' => ['required', 'string', 'max:255'],
            'flutterwave_secret_key' => ['required', 'string', 'max:255'],
            'flutterwave_encryption_key' => ['nullable', 'string', 'max:255'],
            'flutterwave_webhook_url' => ['nullable', 'url', 'max:255'],
        ];
    }

    /**
     * Custom validation messages
     */
    public function messages(): array
    {
        return [
            'flutterwave_status.required' => 'Flutterwave status is required.',
            'flutterwave_status.in' => 'Flutterwave status must be active or inactive.',
            'flutterwave_mode.required' => 'Flutterwave mode is required.',
            'flutterwave_mode.in' => 'Flutterwave mode must be sandbox or live.',
            'flutterwave_country.required' => 'Please select a country.',
            'flutterwave_currency_icon.required' => 'Flutterwave currency icon is required.',
            'flutterwave_currency_rate.required' => 'Currency rate is required.',
            'flutterwave_currency_rate.numeric' => 'Currency rate must be a valid number.',
            'flutterwave_currency_rate.min' => 'Currency rate cannot be negative.',
            'flutterwave_public_key.required' => 'Flutterwave public key is required.',
            'flutterwave_secret_key.required' => 'Flutterwave secret key is required.',
            'flutterwave_webhook_url.url' => 'Webhook URL must be a valid URL.',
        ];
    }
}
