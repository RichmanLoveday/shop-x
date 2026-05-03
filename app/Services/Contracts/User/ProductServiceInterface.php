<?php

namespace App\Services\Contracts\User;

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
    public function productListing(): LengthAwarePaginator;

    public function getProduct(string $slug): Product;
}
