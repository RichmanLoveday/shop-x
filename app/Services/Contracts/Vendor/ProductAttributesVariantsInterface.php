<?php

namespace App\Services\Contracts\Vendor;

use App\Enums\ProductType;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Collection;

interface ProductAttributesVariantsInterface
{
    public function addProductAttributes(int $productId, int $storeId, array $data, ProductType|string $type = ProductType::PHYSICAL): Product;

    public function deleteAttribute(int $attributeId, int $productId, int $storeId, ProductType|string $type = ProductType::PHYSICAL): Product;

    public function deleteAttributeValue(int $attributeValueId, int $attributeId, int $productId, int $storeId): Product;

    public function updateProductVariant(int $productId, int $storeId, array $data, ProductType|string $type = ProductType::PHYSICAL): Product;
}
