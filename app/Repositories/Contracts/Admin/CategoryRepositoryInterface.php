<?php

namespace App\Repositories\Contracts\Admin;

use App\Models\Category;
use App\Repositories\Contracts\Core\BaseCategoryRepositoryInterface;

interface CategoryRepositoryInterface extends BaseCategoryRepositoryInterface
{
    public function addCategory(array $data): Category;

    public function calculatePosition(int $parent_id = null): ?int;

    public function updateCategory(int $id, array $data): Category;

    public function hasThreeOrMoreChildren(int $parent_id): bool;

    public function updateCategoryTree(int $id, array $data): Category;

    public function getCategory(int $id): Category;

    public function checkIfProductCategorySlugExit(string $slug): bool;
}