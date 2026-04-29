<?php

namespace App\Http\Controllers\Vendor;

use App\Enums\ProductAttributeType;
use App\Enums\ProductFilesStatus;
use App\Enums\ProductStatus;
use App\Enums\ProductType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\ProductAttributeStoreRequest;
use App\Http\Requests\Vendor\ProductStoreRequest;
use App\Http\Requests\Vendor\ProductUpdateRequest;
use App\Http\Requests\Vendor\ProductVariantRequestUpdate;
use App\Services\Contracts\Vendor\BrandServiceInterface;
use App\Services\Contracts\Vendor\CategoryServiceInterface;
use App\Services\Contracts\Vendor\ProductAttributesVariantsInterface;
use App\Services\Contracts\Vendor\ProductImagesServiceInterface;
use App\Services\Contracts\Vendor\ProductServiceInterface;
use App\Services\Contracts\Vendor\StoreServiceInterface;
use App\Services\Contracts\Vendor\TagServiceInterface;
use App\Services\Vendor\ProductDigitalFileService;
use App\Traits\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProductController extends Controller
{
    use Alert;

    public function __construct(
        protected StoreServiceInterface $storeService,
        protected CategoryServiceInterface $categoryService,
        protected BrandServiceInterface $brandService,
        protected TagServiceInterface $tagService,
        protected ProductServiceInterface $productService,
        protected ProductDigitalFileService $productDigitalFileService,
        protected ProductImagesServiceInterface $productImagesService,
        protected ProductAttributesVariantsInterface $productAttributeVariants,
    ) {}

    public function index(): View
    {
        $storeId = auth()->guard('web')->user()->store->id;
        // dd($storeId);
        $products = $this->productService->allProducts($storeId);

        // dd($products->toArray());

        return view('vendor-dashboard.product.index', compact('products'));
    }

    public function create()
    {
        $brands = $this->brandService->allBrand();
        $categories = $this->categoryService->nestedCategories();
        $statuses = ProductStatus::cases();

        // dd($categories);
        $tags = $this->tagService->allTags();

        return view('admin.product.create', compact('brands', 'categories', 'tags', 'statuses'));
    }

    public function store(ProductStoreRequest $request, string $type)
    {
        // dd($type);
        try {
            $storeId = auth()->guard('web')->user()->store->id;
            $product = $this->productService->addProduct($request->validated(), $type, $storeId);

            return response()->json([
                'message' => 'Product created successfully',
                'product' => $product,
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

    public function uploadImage(Request $request, string $type, int $productId)
    {
        // dd($request->all());

        $request->validate([
            'image' => ['required', 'mimes:jpeg,png,jpg', 'max:3048'],
        ]);

        try {
            $storeId = auth()->guard('web')->user()->store->id;
            $productImage = $this->productImagesService->uploadImage($productId, $storeId, $request->only('image'), $type);

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
            // $storeId = auth()->guard('web')->user()->store->id;
            $this->productImagesService->deleteProductImage($id);

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

    public function reorderProductImages(Request $request, string $type, int $id)
    {
        // dd($request->images, $id);
        // validate request
        $request->validate([
            'images' => ['required', 'array'],
            'images.*.id' => ['required', 'integer', 'exists:product_images,id'],
            'images.*.position' => ['required', 'integer'],
        ]);

        try {
            $storeId = auth()->guard('web')->user()->store->id;
            $images = $this->productImagesService->reorderProductImages($id, $storeId, $request->images, $type);

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
        $brands = $this->brandService->allBrand();
        $categories = $this->categoryService->nestedCategories();
        $statuses = ProductStatus::cases();
        $attributeTypes = ProductAttributeType::cases();

        // dd($attributeTypes);

        // dd($statuses);
        // dd($categories);
        $tags = $this->tagService->allTags();

        return view('vendor-dashboard.product.edit', compact('product', 'brands', 'categories', 'tags', 'statuses', 'attributeTypes'));
    }

    public function editDigitalProduct(Request $request, int $id)
    {
        $product = $this->productService->getProduct($id, ProductType::DIGITAL);
        // dd($product->toArray());
        // dd($product->toArray());
        $brands = $this->brandService->allBrand();
        $categories = $this->categoryService->nestedCategories();
        $statuses = ProductStatus::cases();
        $attributeTypes = ProductAttributeType::cases();

        // dd($attributeTypes);

        // dd($statuses);
        // dd($categories);
        $tags = $this->tagService->allTags();

        return view('vendor-dashboard.product.digital-edit', compact('product', 'brands', 'categories', 'tags', 'statuses', 'attributeTypes'));
    }

    public function update(ProductUpdateRequest $request, string $type, int $id)
    {
        // dd($id, $type);
        try {
            $storeId = auth()->guard('web')->user()->store->id;
            $product = $this->productService->updateProduct($id, $storeId, $type, $request->validated());

            $this->updated('Product updated successfully');

            return response()->json([
                'message' => 'Product updated successfully',
                'redirectUrl' => route('vendor.products.index'),
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
            $storeId = auth()->guard('web')->user()->store->id;
            $product = $this->productAttributeVariants->addProductAttributes($id, $storeId, $request->validated());
            $attributeTypes = ProductAttributeType::cases();
            $html = view('admin.product.partials.attributes', compact('product', 'attributeTypes'))->render();
            $variants = view('admin.product.partials.variants', compact('product'))->render();

            return response()->json([
                'message' => 'Product attributes added successfully',
                'html' => $html,
                'attributes' => $product->attributes,
                'variants' => $variants,
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
            $storeId = auth()->guard('web')->user()->store->id;
            $product = $this->productAttributeVariants->deleteAttribute(
                $attributeId,
                $productId,
                $storeId,
            );
            $attributeTypes = ProductAttributeType::cases();
            $html = view('admin.product.partials.attributes', compact('product', 'attributeTypes'))->render();
            $variants = view('admin.product.partials.variants', compact('product'))->render();

            return response()->json([
                'message' => 'Product attributes deleted successfully',
                'html' => $html,
                'attributes' => $product->attributes,
                'variants' => $variants,
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
            $storeId = auth()->guard('web')->user()->store->id;
            $product = $this->productAttributeVariants->deleteAttributeValue($attributeValueId, $attributeId, $productId, $storeId);
            $attributeTypes = ProductAttributeType::cases();
            $html = view('admin.product.partials.attributes', compact('product', 'attributeTypes'))->render();
            $variants = view('admin.product.partials.variants', compact('product'))->render();

            return response()->json([
                'message' => 'Product attribute value deleted successfully',
                'html' => $html,
                'variants' => $variants,
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

    public function updateProductVariant(ProductVariantRequestUpdate $request, int $productId)
    {
        try {
            // dd($request->all());
            $storeId = auth()->guard('web')->user()->store->id;
            $product = $this->productAttributeVariants->updateProductVariant($productId, $storeId, $request->all());
            $variants = view('admin.product.partials.variants', compact('product'))->render();

            return response()->json([
                'message' => 'Product variant updated successfully',
                'product' => $product,
                'variants' => $variants,
                'status' => true,
            ], 200);
        } catch (\Exception $e) {
            logger()->error('Failed to update product variant: ' . $e->getMessage());
            return response()->json([
                'message' => 'An e1`111rror occurred while updating product variant',
                'status' => false,
            ], 500);
        }
    }

    public function uploadDigitalProduct(Request $request, string $type, int $productId)
    {
        try {
            // dd($request->all());
            $storeId = auth()->guard('web')->user()->store->id;
            $user = auth()->guard('web')->user();
            $result = $this->productDigitalFileService->handleChunkUpload($productId, $storeId, $user, $type, $request->all());

            // dd($product);

            return response()->json([
                'message' => ProductFilesStatus::from($result['status'])->message(),
                'digitalFile' => $result['digitalFile'] ?? (object) [],
                'status' => $result['status'],
            ], 200);
        } catch (\Exception $e) {
            logger()->error(
                'Failed to upload digital product: ' . $e->getMessage()
            );

            return response()->json([
                'message' => 'An error occurred while uploading digital product',
                'status' => 'failed',
            ], 500);
        }
    }

    public function getDigitalFile(int $productId, int $fileId)
    {
        // dd($productId, $fileId);

        try {
            $storeId = auth()->guard('web')->user()->store->id;
            $digitalFile = $this->productDigitalFileService->getDigitalFile($productId, $storeId, $fileId, ProductType::DIGITAL->value);
            return response()->json([
                'message' => $digitalFile->status->message(),
                'status' => $digitalFile->status->value,
            ], 200);
        } catch (\Exception $e) {
            logger()->error(
                'Failed to get digital files: ' . $e->getMessage()
            );

            return response()->json([
                'message' => 'An error occurred while getting digital files',
                'status' => 'failed',
            ], 500);
        }
    }

    public function checkDigitalFileStatus(int $productId, int $fileId)
    {
        try {
            $storeId = auth()->guard('web')->user()->store->id;
            $digitalFile = $this->productDigitalFileService->getDigitalFile($productId, $storeId, $fileId, ProductType::DIGITAL->value);
            // dd($digitalFile->toArray());
            // var_dump($digitalFile->status);
            return response()->json([
                // 'digitalFile' => $digitalFile,
                'message' => $digitalFile->status->message(),
                'status' => $digitalFile->status->value,
            ], 200);
        } catch (\Exception $e) {
        }
    }

    public function destroyDigitalProductFile(int $productId, int $fileId)
    {
        try {
            $storeId = auth()->guard('web')->user()->store->id;
            $this->productDigitalFileService->deleteDigitalFile($productId, $storeId, $fileId);

            return response()->json([
                'message' => 'File deleted successfully',
                'status' => true,
            ], 200);
        } catch (\Exception $e) {
            logger()->error('Failed to delete file: ' . $e);
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while deleting file',
            ]);
        }
    }

    public function destroyProduct(string $type, int $id)
    {
        // dd($id, $type);
        try {
            $storeId = auth()->guard('web')->user()->store->id;
            $this->productService->deleteProduct($id, $storeId, $type);

            $this->deleted('Product Deleted successfully');
            return response()->json([
                'message' => 'Product deleted successfully',
                'status' => true,
            ], 200);
        } catch (\Exception $e) {
            logger()->error('Failed to delete product: ' . $e);
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while deleting product',
            ]);
        }
    }
}