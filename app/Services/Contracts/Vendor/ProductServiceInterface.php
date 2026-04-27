<?php

namespace App\Services\Contracts\Vendor;

use App\Enums\ProductType;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductFile;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductServiceInterface
{
    public function addProduct(array $data, int $storeId, string $type): Product;

    public function updateProduct(int $id, int $storeId, ProductType|string $type, array $data): Product;

    public function allProducts(int $storeId): LengthAwarePaginator;

    public function getProduct(int $id, int $storeId, ProductType|string $type = ProductType::PHYSICAL): Product;

    public function deleteProduct(int $id, int $storeId, Admin $user, ProductType|string $type): bool;
}
