<?php

namespace App\Services\Vendor;

use App\Models\Category;
use App\Repositories\Contracts\Vendor\CategoryRepositoryInterface;
use App\Services\Contracts\Vendor\CategoryServiceInterface;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Exception;

class CategoryService extends BaseService implements CategoryServiceInterface
{
    public function __construct(
        protected CategoryRepositoryInterface $categoryRepo,
    ) {}

    public function search(string $name): Collection
    {
        return $this->categoryRepo->searchCategory($name);
    }

    public function nestedCategories(?int $parentId = null, int $depth = 0, int $maxDepth = 3): Collection|array
    {
        if ($depth >= $maxDepth)
            return [];

        $categories = $this->categoryRepo->categoriesByParents($parentId);

        // loop through and get nested children based on id, depth, and max depth
        foreach ($categories as $cat) {
            // $cat->children_nested = $this->nestedCategories($cat->id, $depth + 1, $maxDepth);
            $cat->children = $this->nestedCategories($cat->id, $depth + 1, $maxDepth);
        }

        return $categories;

        // return $this->categoryRepo->getNestedCategories();
    }
}
