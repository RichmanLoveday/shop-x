<?php

namespace App\Repositories\Eloquent\User;

use App\Enums\ProductApprovedStatus;
use App\Enums\ProductStatus;
use App\Models\Product;
use App\Repositories\Contracts\User\Product as UserProduct;
use App\Repositories\Contracts\User\ProductRepositoryInterface;
use App\Repositories\Eloquent\Core\BaseProductRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Override;

class ProductRepository extends BaseProductRepository implements ProductRepositoryInterface
{
    public function getProducts(): LengthAwarePaginator
    {
        return Product::query()
            ->with(['images' => function ($q) {
                $q->limit(1);
            }, 'categories', 'store:id,name', 'primaryVariant'])
            ->where('status', ProductStatus::ACTIVE)
            ->where('approved_status', ProductApprovedStatus::APPROVED)
            ->latest()
            ->paginate(20);
    }

    public function findProductBySlug(string $slug): Product
    {
        $product = Product::query()
            ->where('slug', $slug)
            ->firstOrFail();

        $product->load([
            'images:id,path,product_id',
            'categories',
            'store:id,name',
            'primaryVariant',
            'tags',
            'variants',
            'attributeWithValues' => function ($query) use ($product) {
                $query->withValuesForProduct($product->id);
            }
        ]);

        return $product;
    }
}
