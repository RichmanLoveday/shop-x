<?php

namespace App\Services\Admin;

use App\Models\Category;
use App\Repositories\Contracts\Admin\ProductRepositoryInterface;
use App\Services\Contracts\Admin\CategoryServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
        $payload['slug'] = $this->createSlug($data['name']);
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

    public function allCategories(): Collection
    {
        return $this->productRepo->getAllCategories();
    }

    public function nestedCategories(?int $parentId = null, int $depth = 0, int $maxDepth = 3): Collection|array
    {
        if ($depth >= $maxDepth)
            return [];

        $categories = $this->productRepo->categoriesByParents($parentId);

        // loop through and get nested children based on id, depth, and max depth
        foreach ($categories as $cat) {
            // $cat->children_nested = $this->nestedCategories($cat->id, $depth + 1, $maxDepth);
            $cat->children = $this->nestedCategories($cat->id, $depth + 1, $maxDepth);
        }

        return $categories;

        // return $this->productRepo->getNestedCategories();
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

                // Check max children (not depth)
                // if (!is_null($data['parent_id']) && $this->productRepo->hasThreeOrMoreChildren($parentId)) {
                //     throw ValidationException::withMessages([
                //         'parent_id' => 'Maximum depth reached',
                //     ]);
                // }

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

    public function updateCategory(int $categoryId, array $data): Category
    {
        $category = $this->getCategory($categoryId);

        // dd($data);
        // extract needed data
        $payload['name'] = $data['name'];
        $payload['parent_id'] = $data['parent_id'];
        $payload['slug'] = $category->name !== $data['name'] ? $this->createSlug($data['name']) : $category->slug;
        $payload['is_active'] = $data['is_active'];

        $newParentId = $data['parent_id'] ?? null;
        $isSameParent = (int) $category->parent_id === (int) $newParentId;

        $payload['position'] = $isSameParent
            ? $category->position
            : $this->productRepo->calculatePosition($newParentId);

        // Check max children (not depth)
        if (!is_null($data['parent_id']) && $this->productRepo->hasThreeOrMoreChildren($data['parent_id'])) {
            throw ValidationException::withMessages([
                'parent_id' => 'Maximum depth reached',
            ]);
        }

        // dd($payload);
        // create new category
        return $this->productRepo->updateCategory($categoryId, $payload);
    }

    public function deleteCategory(int $categoryId): bool
    {
        $category = $this->getCategory($categoryId);

        // check if category has children and restrict delete
        if ($category->children()->count() > 0) {
            throw new Exception('Category has children and cannot be deleted!');
        }

        return $category->delete();
    }

    public function getCategory(int $categoryId): Category
    {
        return $this->productRepo->getCategory($categoryId);
    }

    
    public function search(string $name): Collection
    {
        return $this->productRepo->searchCategory($name);
    }

    private function createSlug(string $categoryName): string
    {
        $slug = Str::slug($categoryName, '-');
        $originalSlug = $slug;
        $count = 1;

        while ($this->productRepo->checkIfProductCategorySlugExit($slug)) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }
}
