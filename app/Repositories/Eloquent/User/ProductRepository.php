<?php

namespace App\Repositories\Eloquent\User;

use App\Enums\ProductApprovedStatus;
use App\Enums\ProductStatus;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Repositories\Contracts\User\Product as UserProduct;
use App\Repositories\Contracts\User\ProductRepositoryInterface;
use App\Repositories\Eloquent\Core\BaseProductRepository;
use Illuminate\Database\Eloquent\Collection;
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
            'store',
            'primaryVariant',
            'tags',
            'variants' => function ($q) {
                $q->where('is_active', true);
            },
            'attributeWithValues' => function ($query) use ($product) {
                $query->withValuesForProduct($product->id);
            }
        ]);

        return $product;
    }

    public function findRelatedProducts(Product $product): Collection
    {
        return Product::query()
            ->with([
                'images:id,path,product_id',
                'categories',
                'store',
                'primaryVariant',
                'tags',
                'variants' => function ($q) {
                    $q->where('is_active', true);
                },
                'attributeWithValues' => function ($query) use ($product) {
                    $query->withValuesForProduct($product->id);
                }
            ])
            ->whereHas('categories', function ($query) use ($product) {
                $query->whereIn('categories.id', $product->categories->pluck('id')->toArray());
            })
            ->where('id', '!=', $product->id)
            ->where(['status' => true, 'approved_status' => ProductApprovedStatus::APPROVED])
            ->distinct()
            ->take(6)
            ->get();
    }

    public function findProductVariant(int $productId, ?int $variantId): ProductVariant|Null
    {
        if (!$variantId) {
            return null;
        }

        return ProductVariant::query()
            ->where('id', $variantId)
            ->where('product_id', $productId)
            ->where('is_active', true)
            ->first();
    }
}