<?php

namespace App\Repositories\Eloquent\Core;

use App\Models\Brand;
use App\Repositories\Contracts\Core\BaseBrandRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BaseBrandRepository implements BaseBrandRepositoryInterface
{
    public function getAllBrand(): LengthAwarePaginator
    {
        return Brand::query()
            ->paginate(25);
    }

    public function findBrand(string $name): Collection
    {
        return Brand::query()
            ->where('name', 'like', "%{$name}%")
            ->where('is_active', true)
            ->get();
    }
}