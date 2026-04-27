<?php

namespace App\Repositories\Contracts\Admin;

use App\Models\Brand;
use App\Repositories\Contracts\Core\BaseBrandRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

interface BrandRepositoryInterface extends BaseBrandRepositoryInterface
{
    public function createBrand(array $data): Brand;

    public function updateBrand(int $id, array $data): Brand;

    public function getBrand(int $id): Brand;

    public function getAllBrand(): LengthAwarePaginator;

    public function checkIfBrandSlugExit(string $slug): bool;
}