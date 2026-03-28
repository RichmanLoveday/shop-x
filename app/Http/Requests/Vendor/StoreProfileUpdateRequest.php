<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProfileUpdateRequest extends FormRequest
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
            'logo' => ['nullable', 'image', 'max:2048'],
            'banner' => ['nullable', 'image', 'max:2048'],
            'name' => ['required', 'string', 'max:50'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:50'],
            'address' => ['nullable', 'string', 'max:255'],
            'short_desc' => ['required', 'string', 'max:255'],
            'long_desc' => ['required', 'string', 'max:2000']
        ];
    }
}
