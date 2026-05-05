<?php

namespace App\Services\User;

use App\Enums\ProductApprovedStatus;
use App\Enums\ProductType;
use App\Models\Admin;
use App\Models\Product;
use App\Repositories\Contracts\User\ProductRepositoryInterface;
use App\Services\Contracts\User\ProductServiceInterface;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Override;

class ProductService extends BaseService implements ProductServiceInterface
{
    public function __construct(
        protected ProductRepositoryInterface $productRepo,
    ) {}

    public function productListing(): LengthAwarePaginator
    {
        return $this->productRepo->getProducts();
    }

    public function getProduct(string $slug): Product
    {
        return $this->productRepo->findProductBySlug($slug);
    }

    public function getRelatedProducts(string $slug): Collection
    {
        $product = $this->productRepo->findProductBySlug($slug);
        return $this->productRepo->findRelatedProducts($product);
    }

    public function getProductById(int $id, string|ProductType $type): Product
    {
        return $this->productRepo->getProduct($id, $type);
    }
}
