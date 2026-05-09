<?php

namespace App\Repositories\Contracts\User;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Repositories\Contracts\Core\BaseProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface extends BaseProductRepositoryInterface
{
    public function getProducts(): LengthAwarePaginator;

    public function findProductBySlug(string $slug): Product;

    public function findRelatedProducts(Product $product): Collection;

    public function findProductVariant(int $productId, ?int $variantId): ProductVariant|Null;
}
