<?php

namespace App\Repositories\Eloquent\Admin;

use App\Models\Category;
use App\Repositories\Contracts\Admin\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    public function addCategory(array $data): Category
    {
        return Category::query()
            ->create($data);
    }

    public function updateCategory(int $id, array $data): Category
    {
        $category = $this->getProductCategory($id);

        $category->update($data);

        return $category;
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
        $category = $this->getProductCategory($id);

        $category->update([
            'parent_id' => $data['parent_id'],
            'position' => $data['position'],
        ]);

        return $category;
    }

    public function updateProductCategory(int $id, array $data): Category
    {
        $category = $this->getProductCategory($id);

        $category->update($data);

        return $category;
    }

    public function getNestedCategories(): Collection
    {
        return Category::whereNull('parent_id')
            ->with(['children.children'])
            ->orderBy('position')
            ->get();
    }

    public function getProductCategory(int $id): Category
    {
        return Category::findOrFail($id);
    }

    public function checkIfProductCategorySlugExit(string $slug): bool
    {
        return Category::query()
            ->where('slug', $slug)
            ->exists();
    }
}