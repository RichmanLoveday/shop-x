<?php
namespace App\Services\Contracts\Vendor;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface BrandServiceInterface
{
    public function findBrand(string $brandName): Collection;

    public function allBrand(): LengthAwarePaginator;
}
