<?php

namespace App\Repositories\Eloquent\Admin;

use App\Models\Brand;
use App\Repositories\Contracts\Admin\BrandRepositoryInterface;
use App\Repositories\Eloquent\Core\BaseBrandRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class BrandRepository extends BaseBrandRepository implements BrandRepositoryInterface
{
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
}
