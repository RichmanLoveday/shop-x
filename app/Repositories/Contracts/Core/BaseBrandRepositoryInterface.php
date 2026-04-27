<?php

namespace App\Repositories\Contracts\Core;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseBrandRepositoryInterface
{
    public function getAllBrand(): LengthAwarePaginator;

    public function findBrand(string $name): Collection;
}
