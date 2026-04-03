<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductCategoryCreateRequest;
use App\Services\Contracts\Admin\CategoryServiceInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryServiceInterface $categoryService
    ) {}

    public function index()
    {
        return view('admin.category.index');
    }

    public function store(ProductCategoryCreateRequest $request)
    {
        try {
            // dd($request->all());
            $category = $this->categoryService->addNewCategory($request->validated());

            return response()->json([
                'message' => 'Category Added successfully',
                'status' => true,
                'category' => $category,
            ]);
        } catch (\Exception $e) {
            logger()->error('Failed to create category: ' . $e->getMessage());
            return response()->json([
                'message' => $e->getMessage(),
                'status' => false,
            ]);
        }
    }

    public function getNestedCategories()
    {
        try {
            $categories = $this->categoryService->nestedCategories();
            // dd($categories->toArray());
            return response()->json([
                'categories' => $categories,
                'message' => 'Categories fetched successfully',
                'status' => true,
            ]);
        } catch (\Exception $th) {
            logger()->error('Failed to load nested categories: ' . $th->getMessage());
            return response()->json(['message' => 'An error occurred while getting data', 'status' => false]);
        }
    }

    public function updateOrder(Request $request)
    {
        // dd($request->tree);

        try {
            $categories = $this->categoryService->reOrderCategory($request->tree);

            return response()->json([
                'categories' => $categories,
                'message' => 'Categories reordered successfully',
                'status' => true,
            ], 200);
        } catch (\Exception $e) {
            logger()->error('Failed to update order: ' . $e->getMessage());

            return response()->json([
                'message' => 'An error occurred while reordering',
                'status',
                false,
            ], 500);
        }
    }
}
