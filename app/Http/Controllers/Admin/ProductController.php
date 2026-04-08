<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProductStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductStoreRequest;
use App\Services\Contracts\Admin\BrandServiceInterface;
use App\Services\Contracts\Admin\CategoryServiceInterface;
use App\Services\Contracts\Admin\ProductServiceInterface;
use App\Services\Contracts\Admin\StoreServiceInterface;
use App\Services\Contracts\Admin\TagServiceInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        protected StoreServiceInterface $storeService,
        protected CategoryServiceInterface $categoryService,
        protected BrandServiceInterface $brandService,
        protected TagServiceInterface $tagService,
        protected ProductServiceInterface $productService,
    ) {}

    public function index(): View
    {
        $products = [];

        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        $brands = $this->brandService->allBrands();
        $categories = $this->categoryService->nestedCategories();
        $statuses = ProductStatus::cases();
        // dd($categories);
        $tags = $this->tagService->allTags();

        return view('admin.product.create', compact('brands', 'categories', 'tags', 'statuses'));
    }

    public function store(ProductStoreRequest $request)
    {
        try {
            $product = $this->productService->addProduct($request->validated());
            
            return response()->json([
                'message' => 'Product created successfully',
                'redirectUrl' => route('admin.products.index'),
                'status' => true,
            ]);
        } catch (\Exception $e) {
            logger()->error('Failed to create product: ' . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred while creating product',
                'status' => false,
            ], 500);
        }
    }
}