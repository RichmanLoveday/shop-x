<?php

namespace App\Repositories\Contracts\Core;

use Illuminate\Database\Eloquent\Collection;

interface BaseCategoryRepositoryInterface
{
    public function getAllCategories(): Collection;

    public function getNestedCategories(): Collection;

    public function categoriesByParents(?int $parent_id = null): Collection;

    public function searchCategory(string $name): Collection;
}