<?php

namespace App\Repositories\Contracts\Admin;

use App\Enums\ProductType;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Tag;
use Dom\Attr;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use PhpCsFixer\Tokenizer\CT;

interface ProductRepositoryInterface
{
    // CATEGORY INTERFACES
    public function addCategory(array $data): Category;

    public function getAllCategories(): Collection;

    public function calculatePosition(int $parent_id = null): ?int;

    public function updateCategory(int $id, array $data): Category;

    public function categoriesByParents(?int $parent_id = null): Collection;

    public function getNestedCategories(): Collection;

    public function hasThreeOrMoreChildren(int $parent_id): bool;

    public function updateCategoryTree(int $id, array $data): Category;

    public function getCategory(int $id): Category;

    public function checkIfProductCategorySlugExit(string $slug): bool;

    public function searchCategory(string $name): Collection;

    // TAG INTERFACES
    public function createTag(array $data): Tag;

    public function checkIfTagSlugExit(string $slug): bool;

    public function getAllTags(): LengthAwarePaginator;

    public function getTag(int $id): Tag;

    public function updateTag(int $id, array $data): Tag;

    public function findTag(string $name): Collection;

    // BRAND INTERFACES
    public function createBrand(array $data): Brand;

    public function updateBrand(int $id, array $data): Brand;

    public function getBrand(int $id): Brand;

    public function getAllBrand(): LengthAwarePaginator;

    public function checkIfBrandSlugExit(string $slug): bool;

    public function findBrand(string $name): Collection;

    // PRODUCT INTERFACES
    public function createProduct(array $data): Product;

    public function getProduct(int $id, ProductType|string $type = ProductType::PHYSICAL): Product;

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

    public function getAllProducts(): LengthAwarePaginator;

    public function resetDefaultVariants(int $productId, int $variantId): void;
}
