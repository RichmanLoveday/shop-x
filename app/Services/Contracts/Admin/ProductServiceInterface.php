<?php

namespace App\Services\Contracts\Admin;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

interface ProductServiceInterface
{
    public function addProduct(array $data): Product;

    public function updateProduct(int $id, array $data): Product;

    public function allProducts(): Collection;

    public function getProduct(int $id): Product;
}
