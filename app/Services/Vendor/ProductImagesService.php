<?php

namespace App\Services\Vendor;

use App\Enums\ProductType;
use App\Models\ProductImage;
use App\Repositories\Contracts\Admin\ProductRepositoryInterface;
use App\Services\Contracts\Admin\ProductImagesServiceInterface;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class ProductImagesService extends BaseService implements ProductImagesServiceInterface
{
    public function __construct(
        protected ProductRepositoryInterface $productRepo,
    ) {}

    public function uploadImage(int $productId, array $data, ProductType|string $type = ProductType::PHYSICAL): ProductImage
    {
        // check if product exist in both product image model and products model
        if (!$this->productRepo->getProduct($productId, $type))
            throw new \Exception('Product not found');

        // check if product image is already more that 5 images
        $productImages = $this->productRepo->getProductImages($productId);

        if (count($productImages) >= 5) {
            throw new \Exception('You can only upload up to 5 images for a product');
        }

        // dd($productId, $data);
        $payload['product_id'] = $productId;
        $payload['order'] = $this->productRepo->calculateProductImageMaxOrder($productId);

        // document to upload
        $document = $data['image'];
        return DB::transaction(function () use ($payload, $document) {
            $productImage = $this->productRepo->uploadProductImage($payload);

            // Handle document upload if provided
            if ($document instanceof UploadedFile) {
                $this->uploadMedia($productImage, $document, 'product_image', 'path');
            }

            return $productImage->fresh();
        });
    }

    public function deleteProductImage(int $id): bool
    {
        $productImage = $this->productRepo->findProductImage($id);
        // dd($productImage);

        // Delete associated media from Spatie Media Library
        $productImage->getMedia('product_image')->each->delete();

        return $productImage->delete();
    }

    public function reorderProductImages(int $productId, array $images, ProductType|string $type = ProductType::PHYSICAL): Collection
    {
        $productImages = $this->productRepo->getProduct($productId, $type)->images;

        // Create a map of id to position
        $orderMap = [];
        foreach ($images as $imageData) {
            $orderMap[$imageData['id']] = $imageData['position'];
        }

        foreach ($productImages as $image) {
            if (isset($orderMap[$image->id])) {
                $image->order = $orderMap[$image->id];
                $image->save();
            }
        }

        return $productImages->fresh();
    }
}