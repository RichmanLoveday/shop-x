<?php

namespace App\Repositories\Eloquent\Core;

use App\Models\Category;
use App\Repositories\Contracts\Core\BaseCategoryRepositoryInterface;
use Dom\Attr;
use Illuminate\Database\Eloquent\Collection;

class BaseCategoryRepository implements BaseCategoryRepositoryInterface
{
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

    public function getNestedCategories(): Collection
    {
        return Category::whereNull('parent_id')
            ->with(['children.children.children'])
            ->orderBy('position')
            ->get();
    }

    public function categoriesByParents(?int $parent_id = null): Collection
    {
        return Category::query()
            ->where('parent_id', $parent_id)
            ->orderBy('position')
            ->get();
    }
}
