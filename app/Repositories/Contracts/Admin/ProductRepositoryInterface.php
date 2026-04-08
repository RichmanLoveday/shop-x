<?php

namespace App\Repositories\Contracts\Admin;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
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

    public function checkIfProductSlugExit(string $slug): bool;
}
