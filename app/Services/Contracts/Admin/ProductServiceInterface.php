<?php

namespace App\Services\Contracts\Admin;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Collection;

interface ProductServiceInterface
{
    public function addProduct(array $data): Product;

    public function updateProduct(int $id, array $data): Product;

    public function allProducts(): Collection;

    public function getProduct(int $id): Product;

    public function uploadImage(int $productId, array $data): ProductImage;

    public function deleteProductImage(int $id): bool;

    public function reorderProductImages(int $productId, array $images): Collection;
}
