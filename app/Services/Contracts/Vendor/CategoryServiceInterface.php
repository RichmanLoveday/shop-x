<?php

namespace App\Services\Contracts\Vendor;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use PHPUnit\Runner\DeprecationCollector\Collector;

interface CategoryServiceInterface
{
    public function search(string $name): Collection;

    public function nestedCategories(?int $parentId = null, int $depth = 0, int $maxDepth = 3): Collection|array;
}
