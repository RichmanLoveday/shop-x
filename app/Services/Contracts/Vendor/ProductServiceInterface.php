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
    public function addProduct(array $data, string $type, ?int $storeId = null): Product;

    public function updateProduct(int $id, int $storeId, ProductType|string $type, array $data): Product;

    public function allProducts(int $storeId): LengthAwarePaginator;

    public function getProduct(int $id, ProductType|string $type = ProductType::PHYSICAL, ?int $storeId = null): Product;

    public function deleteProduct(int $id, int $storeId, ProductType|string $type): bool;
}
