<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProductAttributeType;
use App\Enums\ProductStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductAttributeStoreRequest;
use App\Http\Requests\Admin\ProductStoreRequest;
use App\Http\Requests\Admin\ProductUpdateRequest;
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
                'product' => $product,
                'redirectUrl' => route('admin.products.edit', $product->id) . '#product-images',
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

    public function uploadImage(Request $request, int $productId)
    {
        // dd($request->all());

        $request->validate([
            'image' => ['required', 'mimes:jpeg,png,jpg', 'max:3048'],
        ]);

        try {
            $productImage = $this->productService->uploadImage($productId, $request->only('image'));

            return response()->json([
                'message' => 'Product image added successfully',
                'productImage' => $productImage,
                'status' => true,
            ]);
        } catch (\Exception $e) {
            logger()->error('Failed to upload product image: ' . $e->getMessage());
            return response()->json([
                'message' => $e->getMessage(),
                'status' => false,
            ], 500);
        }
    }

    public function destroyProductImage(int $id)
    {
        try {
            $this->productService->deleteProductImage($id);

            return response()->json([
                'message' => 'Image removed successfully',
                'status' => true,
            ]);
        } catch (\Exception $e) {
            logger()->error('Failed to remove image: ' . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred while removing image',
                'status' => false,
            ], 500);
        }
    }

    public function reorderProductImages(Request $request, int $id)
    {
        // dd($request->images, $id);
        // validate request
        $request->validate([
            'images' => ['required', 'array'],
            'images.*.id' => ['required', 'integer', 'exists:product_images,id'],
            'images.*.position' => ['required', 'integer'],
        ]);

        try {
            $images = $this->productService->reorderProductImages($id, $request->images);

            return response()->json([
                'message' => 'Images reordered successfully',
                'productImages' => $images,
                'status' => true,
            ]);
        } catch (\Exception $e) {
            logger()->error('Failed to reorder images: ' . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred while reordering images',
                'status' => false,
            ], 500);
        }
    }

    public function edit(int $id)
    {
        $product = $this->productService->getProduct($id);
        // dd($product->toArray());
        // dd($product->toArray());
        $brands = $this->brandService->allBrands();
        $categories = $this->categoryService->nestedCategories();
        $statuses = ProductStatus::cases();
        $attributeTypes = ProductAttributeType::cases();

        // dd($attributeTypes);

        // dd($statuses);
        // dd($categories);
        $tags = $this->tagService->allTags();

        return view('admin.product.edit', compact('product', 'brands', 'categories', 'tags', 'statuses', 'attributeTypes'));
    }

    public function update(ProductUpdateRequest $request, int $id)
    {
        try {
            $product = $this->productService->updateProduct($id, $request->validated());

            return response()->json([
                'message' => 'Product updated successfully',
                'product' => $product,
                'status' => true,
            ]);
        } catch (\Exception $e) {
            logger()->error('Failed to update product: ' . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred while updating product',
                'status' => false,
            ], 500);
        }
    }

    public function storeAttributes(ProductAttributeStoreRequest $request, int $id)
    {
        // dd($request->all());

        try {
            $product = $this->productService->addProductAttributes($id, $request->validated());
            return response()->json([
                'message' => 'Product attributes added successfully',
                'product' => $product,
                'status' => true,
            ], 200);
        } catch (\Exception $e) {
            logger()->error('Failed to add product attributes: ' . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred while adding product attributes',
                'status' => false,
            ], 500);
        }
    }

    public function destroyAttribute(int $productId, int $attributeId)
    {
        // dd($productId, $attributeId);

        try {
            $product = $this->productService->deleteAttribute($attributeId, $productId);
            return response()->json([
                'message' => 'Product attributes deleted successfully',
                'product' => $product,
                'status' => true,
            ], 200);
        } catch (\Exception $e) {
            logger()->error('Failed to add product attributes: ' . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred while deleting product attributes',
                'status' => false,
            ], 500);
        }
    }

    public function destroyAttributeValue(int $productId, int $attributeId, int $attributeValueId)
    {
        try {
            $product = $this->productService->deleteAttributeValue($attributeValueId, $attributeId, $productId);
            return response()->json([
                'message' => 'Product attribute value deleted successfully',
                'product' => $product,
                'status' => true,
            ], 200);
        } catch (\Exception $e) {
            logger()->error('Failed to add product attribute value: ' . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred while deleting product attribute value',
                'status' => false,
            ], 500);
        }
    }
}