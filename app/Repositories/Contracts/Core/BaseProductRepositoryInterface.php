<?php

namespace App\Repositories\Contracts\Core;

use App\Enums\ProductType;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Models\ProductFile;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseProductRepositoryInterface
{
    public function createProduct(array $data): Product;

    public function getProduct(int $id, ProductType|string $type = ProductType::PHYSICAL, ?int $storId = null): Product;

    public function getProductImages(int $productId): Collection;

    public function checkIfProductSlugExit(string $slug): bool;

    public function calculateProductImageMaxOrder(int $productId): int;

    public function uploadProductImage(array $data): ProductImage;

    public function findProductImage(int $id): ProductImage;

    public function updateProduct(Product $product, array $data): Product;

    public function createOrUpdateAttribute(array $data, ?int $attributeId = null): Attribute;

    public function createAttributeValues(int $attributeId, array $data): AttributeValue;

    public function createProductAttributeValues(int $productId, int $attributeId, int $attribute_value_id): ProductAttributeValue;

    public function clearProductAttributeValues(Product $product, Attribute $attribute): void;

    public function clearAttributeValues(Attribute $attribute): void;

    public function getAttribute(int $attributeId): Attribute;

    public function getAttributeValue(int $attribute_value_id): AttributeValue;

    public function deleteAttribute(Attribute $attribute): bool;

    public function deleteAttributeValue(AttributeValue $attributeValue): bool;

    public function clearExistingProductVariantAttributeValue(int $variantId): void;

    public function getGroupProductAttributes(int $productId): Collection;

    public function getAttributeValues(array $attributeValueIds): Collection;

    public function createOrUpdateProductVariant(array $data, ?int $variantId = null): ProductVariant;

    public function getProductVariant(int $productVariantId): ProductVariant;

    public function getAllProducts(?int $storId = null): LengthAwarePaginator;

    public function resetDefaultVariants(int $productId, int $variantId): void;

    public function createDigitalFile(array $data): ProductFile;

    public function findDigitalFile(int $id, int $productId): ProductFile;
}