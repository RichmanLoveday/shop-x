<?php

namespace App\Repositories\Eloquent\Admin;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Tag;
use App\Repositories\Contracts\Admin\ProductRepositoryInterface;
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
            ->with(['categories', 'tags', 'brand', 'images', 'store'])
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
}