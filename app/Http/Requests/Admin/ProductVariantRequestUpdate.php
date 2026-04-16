<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductVariantRequestUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;  // Change to true (you should check authorization properly in production)
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'variant_id' => 'required|integer|exists:product_variants,id',
            // 'variant_sku' => 'required|string|max:255|unique:product_variants,sku,' . $this->variant_id . ',id',
            'variant_price' => 'required|numeric|min:0',
            'variant_special_price' => 'nullable|numeric|min:0|lte:variant_price',
            'variant_quantity' => 'nullable|integer|min:0',
            'variant_stock_status' => 'nullable|in:in_stock,out_of_stock',
            'variant_is_active' => 'boolean',
            'variant_is_default' => 'boolean',
            'attribute_id' => 'nullable|integer',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'variant_id.required' => 'Variant ID is required.',
            'variant_id.exists' => 'The selected variant does not exist.',
            'variant_sku.required' => 'SKU is required.',
            'variant_sku.unique' => 'This SKU is already taken by another variant.',
            'variant_sku.max' => 'SKU cannot be longer than 255 characters.',
            'variant_price.required' => 'Price is required.',
            'variant_price.numeric' => 'Price must be a valid number.',
            'variant_price.min' => 'Price cannot be negative.',
            'variant_special_price.numeric' => 'Special price must be a valid number.',
            'variant_special_price.min' => 'Special price cannot be negative.',
            'variant_special_price.lte' => 'Special price cannot be higher than the regular price.',
            'variant_quantity.integer' => 'Quantity must be a whole number.',
            'variant_quantity.min' => 'Quantity cannot be negative.',
            'variant_stock_status.in' => 'Stock status must be either "In Stock" or "Out of Stock".',
        ];
    }

    /**
     * Optional: Conditional validation (e.g. require quantity only when manage stock is checked)
     */
    protected function prepareForValidation()
    {
        // Convert checkbox values to boolean
        $this->merge([
            'variant_is_active' => $this->has('variant_is_active'),
            'variant_is_default' => $this->has('variant_is_default'),
        ]);
    }
}
