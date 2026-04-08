<?php

namespace App\Services\Contracts\Admin;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use PHPUnit\Runner\DeprecationCollector\Collector;

interface CategoryServiceInterface
{
    public function addNewCategory(array $data): Category;

    public function updateCategory(int $categoryId, array $data): Category;

    public function nestedCategories(?int $parentId = null, int $depth = 0, int $maxDepth = 3): Collection|array;

    public function reOrderCategory(array $nodes, ?int $parentId = null): Collection;

    public function getCategory(int $categoryId): Category;

    public function deleteCategory(int $categoryId): bool;

    public function allCategories(): Collection;

    public function search(string $name): Collection;
}
