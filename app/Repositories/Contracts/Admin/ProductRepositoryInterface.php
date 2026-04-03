<?php

namespace App\Repositories\Contracts\Admin;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface
{
    public function addCategory(array $data): Category;

    public function calculatePosition(int $parent_id = null): ?int;

    public function updateCategory(int $id, array $data): Category;

    public function categoriesByParents(?int $parent_id = null): Collection;

    public function hasThreeOrMoreChildren(int $parent_id): bool;

    public function updateCategoryTree(int $id, array $data): Category;
}
