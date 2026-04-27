<?php
namespace App\Services\Contracts\Admin;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface BrandServiceInterface
{
    public function addBrand(array $data): Brand;

    public function update(int $id, array $data): Brand;

    public function allBrands(): LengthAwarePaginator;

    public function getBrand(int $id): Brand;

    public function findBrand(string $brandName): Collection;

    public function delete(int $id): bool;
}