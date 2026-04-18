<?php

namespace App\Repositories\Eloquent\Admin;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\ProductVariantAttributeValue;
use App\Models\Tag;
use App\Repositories\Contracts\Admin\ProductRepositoryInterface;
use Dom\Attr;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository implements ProductRepositoryInterface
{
    public function addCategory(array $data): Category
    {
        return Category::query()
            ->create($data);
    }

    public function getAllCategories(): Collection
    {
        return Category::select(['name', 'id'])->get();
    }

    public function searchCategory(string $name): Collection
    {
        return Category::query()
            ->where('name', 'like', "%{$name}%")
            ->where('is_active', true)
            ->get();
    }

    public function updateCategory(int $id, array $data): Category
    {
        $category = $this->getCategory($id);

        $category->update($data);

        return $category->fresh();
    }

    public function calculatePosition(?int $parent_id = null): ?int
    {
        return Category::query()
            ->where('parent_id', $parent_id)
            ->max('position') + 1;
    }

    public function categoriesByParents(?int $parent_id = null): Collection
    {
        return Category::query()
            ->where('parent_id', $parent_id)
            ->orderBy('position')
            ->get();
    }

    public function hasThreeOrMoreChildren(int $parent_id): bool
    {
        return Category::query()
            ->where('parent_id', $parent_id)
            ->count() >= 3;
    }

    public function updateCategoryTree(int $id, array $data): Category
    {
        $category = $this->getCategory($id);

        $category->update([
            'parent_id' => $data['parent_id'],
            'position' => $data['position'],
        ]);

        return $category;
    }

    public function getNestedCategories(): Collection
    {
        return Category::whereNull('parent_id')
            ->with(['children.children.children'])
            ->orderBy('position')
            ->get();
    }

    public function getCategory(int $id): Category
    {
        return Category::findOrFail($id);
    }

    public function checkIfProductCategorySlugExit(string $slug): bool
    {
        return Category::query()
            ->where('slug', $slug)
            ->exists();
    }

    public function createTag(array $data): Tag
    {
        return Tag::create($data);
    }

    public function checkIfTagSlugExit(string $slug): bool
    {
        return Tag::query()
            ->where('slug', $slug)
            ->exists();
    }

    public function getAllTags(): LengthAwarePaginator
    {
        return Tag::query()
            ->latest()
            ->paginate(20);
    }

    public function getTag(int $id): Tag
    {
        return Tag::findOrFail($id);
    }

    public function findTag(string $name): Collection
    {
        return Tag::query()
            ->where('name', 'like', "%{$name}%")
            ->where('is_active', true)
            ->get();
    }

    public function updateTag(int $id, array $data): Tag
    {
        $tag = $this->getTag($id);

        $tag->update($data);

        return $tag->fresh();
    }

    public function createBrand(array $data): Brand
    {
        return Brand::create($data);
    }

    public function updateBrand(int $id, array $data): Brand
    {
        $brand = $this->getBrand($id);

        $brand->update($data);

        return $brand->fresh();
    }

    public function getBrand(int $id): Brand
    {
        return Brand::query()
            ->findOrFail($id);
    }

    public function getAllBrand(): LengthAwarePaginator
    {
        return Brand::query()
            ->paginate(25);
    }

    public function checkIfBrandSlugExit(string $slug): bool
    {
        return Brand::query()
            ->where('slug', $slug)
            ->exists();
    }

    public function findBrand(string $name): Collection
    {
        return Brand::query()
            ->where('name', 'like', "%{$name}%")
            ->where('is_active', true)
            ->get();
    }

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

    public function getProduct(int $id): Product
    {
        return Product::query()
            ->with(['categories', 'tags', 'brand', 'images', 'store', 'attributeValues', 'variants', 'attributes',
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
        return Product::with(['categories', 'tags', 'brand', 'images', 'store', 'primaryVariant'])
            ->paginate(25);
    }
}