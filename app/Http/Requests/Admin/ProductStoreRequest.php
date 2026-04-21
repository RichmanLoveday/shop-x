<?php

namespace App\Http\Requests\Admin;

use App\Enums\ProductStatus;
use App\Enums\ProductType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductStoreRequest extends FormRequest
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
            // 'type' => ['required', Rule::enum(ProductType::class)],
            'name' => ['required', 'string', 'max:255'],
            'short_description' => ['nullable', 'string', 'max:2000'],
            'long_description' => ['required', 'string'],
            'sku' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric'],
            'special_price' => ['nullable', 'numeric'],
            'from_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:from_date'],
            'quantity' => ['nullable', 'numeric'],
            'brand_id' => ['required', 'exists:brands,id'],
            'stock_status' => ['required', 'in:in_stock,out_of_stock,pre_order'],
            'store_id' => ['required', 'exists:stores,id'],
            'is_featured' => ['nullable'],
            'categories' => ['required', 'array'],
            'categories.*' => ['required', 'exists:categories,id'],
            'manage_stock' => ['nullable'],
            'is_new' => ['nullable'],
            'is_hot' => ['nullable'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['required', 'exists:tags,id'],
            'thumbnail' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'status' => ['required', Rule::enum(ProductStatus::class)],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Product name is required',
            'long_description.required' => 'Long description is required',
            'sku.required' => 'SKU is required',
            'price.required' => 'Price is required',
            'brand_id.required' => 'Brand is required',
            'brand_id.exists' => 'Selected brand does not exist',
            'stock_status.required' => 'Stock status is required',
            'stock_status.in' => 'Stock status must be one of: in_stock, out_of_stock, pre_order',
            'store_id.required' => 'Store is required',
            'store_id.exists' => 'Selected store does not exist',
            'categories.required' => 'At least one category is required',
            'categories.array' => 'Categories must be an array',
            'categories.*.required' => 'Each category selection is required',
            'categories.*.exists' => 'Selected category does not exist',
            'tags.array' => 'Tags must be an array',
            'tags.*.exists' => 'Selected tag does not exist',
            'thumbnail.required' => 'Product thumbnail image is required',
            'thumbnail.image' => 'Thumbnail must be an image file',
            'thumbnail.mimes' => 'Thumbnail must be a file of type: jpeg, png, jpg',
            'thumbnail.max' => 'Thumbnail image size must not exceed 2MB',
        ];
    }
}
