<?php

namespace App\Services\Admin;

use App\Models\Category;
use App\Repositories\Contracts\Admin\ProductRepositoryInterface;
use App\Services\Contracts\Admin\CategoryServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Exception;

class CategoryService implements CategoryServiceInterface
{
    public function __construct(
        protected ProductRepositoryInterface $productRepo
    ) {}

    public function addNewCategory(array $data): Category
    {
        // extract needed data
        $payload['name'] = $data['name'];
        $payload['slug'] = $data['slug'];
        $payload['parent_id'] = $data['parent_id'];
        $payload['is_active'] = $data['is_active'];
        $payload['position'] = $this->productRepo->calculatePosition($data['parent_id'] ?? null);

        // Check max children (not depth)
        if (!is_null($data['parent_id']) && $this->productRepo->hasThreeOrMoreChildren($data['parent_id'])) {
            throw ValidationException::withMessages([
                'parent_id' => 'Maximum depth reached',
            ]);
        }

        // dd($payload);
        // create new category
        return $this->productRepo->addCategory($payload);
    }

    public function updateCategory(int $categoryId, array $data): Category
    {
        throw new \Exception('Not implemented');
    }

    public function nestedCategories(?int $parentId = null, int $depth = 0, int $maxDepth = 3): Collection|array
    {
        if ($depth >= $maxDepth)
            return [];

        $categories = $this->productRepo->categoriesByParents($parentId);

        // loop through and get nested children based on id, depth, and max depth
        foreach ($categories as $cat) {
            $cat->children_nested = $this->nestedCategories($cat->id, $depth + 1, $maxDepth);
        }

        return $categories;
    }

    public function reOrderCategory(array $nodes, ?int $parentId = null): Collection
    {
        // dd($nodes);

        // handle category reorder with db transaction
        DB::transaction(function () use ($nodes, $parentId) {
            foreach ($nodes as $position => $node) {
                $id = $node['id'];
                $data['parent_id'] = $parentId;
                $data['position'] = $position;

                // update category tree
                $category = $this->productRepo->updateCategoryTree($id, $data);

                // check if node has children and it is an array
                if (isset($node['children']) && is_array($node['children'])) {
                    self::reOrderCategory($node['children'], $category->id);
                }
            }
        });

        // return new nested categories
        return $this->nestedCategories();
    }
}
