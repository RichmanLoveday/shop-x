<?php

namespace App\Services\Contracts\Admin;

use App\Enums\ProductType;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Collection;

interface ProductAttributesVariantsInterface
{
    public function addProductAttributes(int $productId, array $data, ProductType|string $type = ProductType::PHYSICAL): Product;

    public function deleteAttribute(int $attributeId, int $productId, ProductType|string $type = ProductType::PHYSICAL): Product;

    public function deleteAttributeValue(int $attributeValueId, int $attributeId, int $productId): Product;

    public function updateProductVariant(int $productId, array $data, ProductType|string $type = ProductType::PHYSICAL): Product;
}
