<?php

namespace App\Repositories\Eloquent\Core;

use App\Enums\ProductType;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Models\ProductFile;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\ProductVariantAttributeValue;
use App\Repositories\Contracts\Core\BaseProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BaseProductRepository implements BaseProductRepositoryInterface
{
    public function createProduct(array $data): Product
    {
        return Product::query()
            ->create($data);
    }

    public function checkIfProductSlugExit(string $slug): bool
    {
        return Product::query()
            ->where('slug', $slug)
            ->exists();
    }

    public function calculateProductImageMaxOrder(int $productId): int
    {
        return ProductImage::query()
            ->where('product_id', $productId)
            ->max('order') + 1;
    }

    public function uploadProductImage(array $data): ProductImage
    {
        return ProductImage::query()
            ->create($data);
    }

    public function findProductImage(int $id): ProductImage
    {
        return ProductImage::findOrFail($id);
    }

    public function getProduct(int $id, ProductType|string $type = ProductType::PHYSICAL, ?int $storeId = null): Product
    {
        return Product::query()
            ->when($storeId, fn($q) => $q->where('store_id', $storeId))
            ->where('product_type', $type)
            ->with(['categories', 'tags', 'brand', 'images', 'store', 'attributeValues', 'variants', 'attributes', 'files' => function ($query) {
                $query->orderBy('id', 'DESC');
            },
                'attributeWithValues' => function ($query) use ($id) {
                    $query->WithValuesForProduct($id);
                }])
            ->findOrFail($id);
    }

    public function updateProduct(Product $product, array $data): Product
    {
        $product->update($data);

        return $product->fresh();
    }

    public function getProductImages(int $productId): Collection
    {
        return ProductImage::query()
            ->where('product_id', $productId)
            ->orderBy('order')
            ->get();
    }

    public function createOrUpdateAttribute(array $data, ?int $attributeId = null): Attribute
    {
        return Attribute::query()
            ->updateOrCreate([
                'id' => $attributeId,
            ], $data);
    }

    public function createAttributeValues(int $attributeId, array $data): AttributeValue
    {
        return AttributeValue::query()
            ->firstOrCreate([
                'attribute_id' => $attributeId,
                'label' => $data['label'],
                'color' => $data['color'],
            ]);
    }

    public function clearAttributeValues(Attribute $attribute): void
    {
        AttributeValue::query()
            ->where('attribute_id', $attribute->id)
            ->delete();
    }

    public function clearProductAttributeValues(Product $product, Attribute $attribute): void
    {
        ProductAttributeValue::query()
            ->where('product_id', $product->id)
            ->where('attribute_id', $attribute->id)
            ->delete();
    }

    public function createProductAttributeValues(int $productId, int $attributeId, int $attribute_value_id): ProductAttributeValue
    {
        return ProductAttributeValue::query()
            ->firstOrCreate([
                'product_id' => $productId,
                'attribute_id' => $attributeId,
                'attribute_value_id' => $attribute_value_id,
            ]);
    }

    public function getAttribute(int $attributeId): Attribute
    {
        return Attribute::query()
            ->findOrFail($attributeId);
    }

    public function deleteAttribute(Attribute $attribute): bool
    {
        return $attribute->delete();
    }

    public function getAttributeValue(int $attribute_value_id): AttributeValue
    {
        return AttributeValue::query()
            ->findOrFail($attribute_value_id);
    }

    public function deleteAttributeValue(AttributeValue $attributeValue): bool
    {
        return $attributeValue->delete();
    }

    public function clearExistingProductVariantAttributeValue(int $variantId): void
    {
        ProductVariantAttributeValue::query()
            ->where('product_variant_id', $variantId)
            ->delete();
    }

    public function getGroupProductAttributes(int $productId): Collection
    {
        return ProductAttributeValue::query()
            ->where('product_id', $productId)
            ->get()
            ->groupBy('attribute_id');
    }

    public function getAttributeValues(array $attributeValueIds): Collection
    {
        return AttributeValue::query()
            ->whereIn('id', $attributeValueIds)
            ->get();
    }

    public function getProductVariant(int $productVariantId): ProductVariant
    {
        return ProductVariant::query()->findOrFail($productVariantId);
    }

    public function resetDefaultVariants(int $productId, int $currentVariantId): void
    {
        ProductVariant::query()
            ->where('product_id', $productId)
            ->where('id', '!=', $currentVariantId)
            ->update([
                'is_default' => false
            ]);
    }

    public function createOrUpdateProductVariant(array $data, ?int $variantId = null): ProductVariant
    {
        return ProductVariant::updateOrCreate(
            [
                'id' => $variantId ?? null,
            ],
            $data
        );
    }

    public function getAllProducts(): LengthAwarePaginator
    {
        return Product::with([
            'categories',
            'tags',
            'brand',
            'images',
            'store',
            'primaryVariant',
            // 'productFiles'
        ])
            ->orderByDesc('id')
            ->paginate(5);
    }

    public function createDigitalFile(array $data): ProductFile
    {
        return ProductFile::create($data);
    }

    public function findDigitalFile(int $id, int $productId): ProductFile
    {
        return ProductFile::with(['product'])
            ->where('id', $id)
            ->where('product_id', $productId)
            ->firstOrFail();
    }
}