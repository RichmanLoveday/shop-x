<?php

namespace App\Services\User;

use App\Enums\ProductApprovedStatus;
use App\Enums\ProductType;
use App\Models\Admin;
use App\Models\Product;
use App\Repositories\Contracts\User\ProductRepositoryInterface;
use App\Services\Contracts\User\ProductServiceInterface;
use App\Services\BaseService;
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
}