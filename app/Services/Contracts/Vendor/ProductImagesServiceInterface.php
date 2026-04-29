<?php

namespace App\Services\Contracts\Vendor;

use App\Enums\ProductType;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Collection;

interface ProductImagesServiceInterface
{
    public function uploadImage(int $productId, int $storeId, array $data, ProductType|string $type = ProductType::PHYSICAL): ProductImage;

    public function deleteProductImage(int $id): bool;

    public function reorderProductImages(int $productId, int $storeId, array $images, ProductType|string $type = ProductType::PHYSICAL): Collection;
}
