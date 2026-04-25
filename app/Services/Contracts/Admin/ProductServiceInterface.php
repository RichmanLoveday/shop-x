<?php

namespace App\Services\Contracts\Admin;

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
    public function addProduct(array $data, string $type): Product;

    public function updateProduct(int $id, ProductType|string $type, array $data): Product;

    public function allProducts(): LengthAwarePaginator;

    public function getProduct(int $id, ProductType|string $type = ProductType::PHYSICAL): Product;

    public function uploadImage(int $productId, array $data, ProductType|string $type = ProductType::PHYSICAL): ProductImage;

    public function deleteProductImage(int $id): bool;

    public function reorderProductImages(int $productId, array $images, ProductType|string $type = ProductType::PHYSICAL): Collection;

    public function addProductAttributes(int $productId, array $data, ProductType|string $type = ProductType::PHYSICAL): Product;

    public function deleteAttribute(int $attributeId, int $productId, ProductType|string $type = ProductType::PHYSICAL): Product;

    public function deleteAttributeValue(int $attributeValueId, int $attributeId, int $productId): Product;

    public function updateProductVariant(int $productId, array $data, ProductType|string $type = ProductType::PHYSICAL): Product;
}