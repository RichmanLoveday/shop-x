<?php

namespace App\Repositories\Contracts\User;

use App\Models\Product;
use App\Repositories\Contracts\Core\BaseProductRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface extends BaseProductRepositoryInterface
{
    public function getProducts(): LengthAwarePaginator;

    public function findProductBySlug(string $slug): Product;
}
