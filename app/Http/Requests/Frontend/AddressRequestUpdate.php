<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddressRequestUpdate extends FormRequest
{
    /**
     * Determine if user is authorized.
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
            'first_name' => [
                'required',
                'string',
                'max:255',
            ],
            'last_name' => [
                'required',
                'string',
                'max:255',
            ],
            'address' => [
                'required',
                'string',
                'max:1000',
            ],
            'phone' => [
                'required',
                'string',
                'max:20',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
            ],
            'state_id' => [
                'required',
                'integer',
                'exists:states,id',
            ],
            'city_id' => [
                'required',
                'integer',
                'exists:cities,id',
            ],
            'country' => [
                'required',
                Rule::in(['Nigeria']),
            ],
            'zip' => [
                'required',
                'integer',
                'digits_between:4,10',
            ],
            'is_default' => [
                'nullable',
                'boolean',
            ],
        ];
    }

    /**
     * Custom messages.
     */
    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required.',
            'last_name.required' => 'Last name is required.',
            'address.required' => 'Address is required.',
            'phone.required' => 'Phone number is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Enter a valid email address.',
            'city_id.required' => 'City is required.',
            'state_id.required' => 'Please select a state.',
            'state.in' => 'Selected state is invalid.',
            'country.required' => 'Country is required.',
            'country.in' => 'Only Nigeria is allowed.',
            'zip.required' => 'Zip code is required.',
            'zip.integer' => 'Zip code must be numeric.',
            'zip.digits_between' => 'Zip code must be between 4 and 10 digits.',
            'is_default.boolean' => 'Invalid default address value.',
        ];
    }

    /**
     * Normalize checkbox.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_default' => $this->boolean('is_default'),
        ]);
    }
}
