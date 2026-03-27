<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class KycCreateRequest extends FormRequest
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
            'full_name' => ['required', 'max:255', 'string'],
            'dob' => ['required', 'date'],
            'gender' => ['required', 'max:255', 'string'],
            'full_address' => ['required', 'max:255', 'string'],
            'document_type' => ['required', 'max:255', 'string'],
            'document_scan_copy' => ['required', 'mimes:png,jpg,pdf,csv,docx', 'max:10000']
        ];
    }
}
