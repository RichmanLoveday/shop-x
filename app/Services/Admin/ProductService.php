<?php

namespace App\Services\Admin;

use App\Enums\ProductAttributeType;
use App\Models\Product;
use App\Models\ProductImage;
use App\Repositories\Contracts\Admin\ProductRepositoryInterface;
use App\Services\Contracts\Admin\ProductServiceInterface;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Pest\Support\Arr;

class ProductService extends BaseService implements ProductServiceInterface
{
    public function __construct(
        protected ProductRepositoryInterface $productRepo,
    ) {}

    public function addProduct(array $data): Product
    {
        // dd($data);
        $payload['name'] = $data['name'];
        $payload['store_id'] = $data['store_id'];
        $payload['brand_id'] = $data['brand_id'];
        $payload['slug'] = $this->generateSlug($data['name'], fn($slug) => $this->productRepo->checkIfProductSlugExit($slug));
        $payload['short_description'] = $data['short_description'];
        $payload['description'] = $data['long_description'];
        $payload['sku'] = $data['sku'];
        $payload['price'] = $data['price'];
        $payload['special_price'] = $data['special_price'];
        $payload['special_price_start'] = $data['from_date'];
        $payload['special_price_end'] = $data['end_date'];
        $payload['qty'] = $data['quantity'];
        $payload['manage_stock'] = isset($data['stock_status']) && $data['stock_status'] == 'in_stock' ? 'yes' : 'no';
        $payload['in_stock'] = isset($data['stock_status']) && $data['stock_status'] == 'in_stock' ? 1 : 0;
        $payload['status'] = $data['status'];
        $payload['is_featured'] = isset($data['is_featured']) ? 1 : 0;
        $payload['is_hot'] = isset($data['is_hot']) ? 1 : 0;
        $payload['is_new'] = isset($data['is_new']) ? 1 : 0;

        $document = $data['thumbnail'] ?? null;

        return DB::transaction(function () use ($payload, $document, $data) {
            $product = $this->productRepo->createProduct($payload);

            // Handle document upload if provided
            if ($document instanceof UploadedFile) {
                $this->uploadMedia($product, $document, 'product_thumbnail', 'thumbnail');
            }

            // attach categories
            $product->categories()->sync($data['categories']);

            // attach tags
            $product->tags()->sync($data['tags']);

            return $product->fresh();
        });
    }

    public function getProduct(int $id): Product
    {
        return $this->productRepo->getProduct($id);
    }

    public function allProducts(): Collection
    {
        throw new \Exception('Not implemented');
    }

    public function updateProduct(int $id, array $data): Product
    {
        // check if product exist
        $product = $this->productRepo->getProduct($id);

        if (!$product)
            throw new \Exception('Product not found');

        // dd($data);

        $payload['name'] = $data['name'];
        $payload['brand_id'] = $data['brand_id'];
        $payload['short_description'] = $data['short_description'];
        $payload['description'] = $data['long_description'];
        $payload['sku'] = $data['sku'];
        $payload['price'] = $data['price'];
        $payload['special_price'] = $data['special_price'];
        $payload['special_price_start'] = $data['from_date'];
        $payload['special_price_end'] = $data['end_date'];
        $payload['qty'] = $data['quantity'];
        $payload['manage_stock'] = isset($data['stock_status']) && $data['stock_status'] == 'in_stock' ? 'yes' : 'no';
        $payload['in_stock'] = isset($data['stock_status']) && $data['stock_status'] == 'in_stock' ? 1 : 0;
        $payload['status'] = $data['status'];
        $payload['is_featured'] = isset($data['is_featured']) ? 1 : 0;
        $payload['is_hot'] = isset($data['is_hot']) ? 1 : 0;
        $payload['is_new'] = isset($data['is_new']) ? 1 : 0;
        $payload['slug'] = $product->name != $data['name'] ? $this->generateSlug($data['name'], fn($slug) => $this->productRepo->checkIfProductSlugExit($slug)) : $product->slug;

        $document = $data['thumbnail'] ?? null;

        return DB::transaction(function () use ($product, $payload, $document, $data) {
            $updatedProduct = $this->productRepo->updateProduct($product, $payload);

            // Handle document upload if provided
            if ($document instanceof UploadedFile) {
                $this->uploadMedia($updatedProduct, $document, 'product_thumbnail', 'thumbnail');
            }

            // attach categories
            $updatedProduct->categories()->sync($data['categories']);

            // attach tags
            $updatedProduct->tags()->sync($data['tags']);

            return $updatedProduct->fresh();
        });
    }

    public function uploadImage(int $productId, array $data): ProductImage
    {
        // check if product exist in both product image model and products model
        if (!$this->productRepo->getProduct($productId))
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

        // Delete associated media from Spatie Media Library
        $productImage->getMedia('product_image')->each->delete();

        return $productImage->delete();
    }

    public function reorderProductImages(int $productId, array $images): Collection
    {
        $productImages = $this->productRepo->getProduct($productId)->images;

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

    public function addProductAttributes(int $productId, array $data): Product
    {
        // dd($data);
        return DB::transaction(function () use ($productId, $data) {
            // check if product exist
            $product = $this->getProduct($productId);

            // Convert the string from request to an actual Enum instance
            // dd($data['attribute_type'] ?? null);
            $type = ProductAttributeType::from($data['attribute_type']);
            $attributeId = $data['attribute_id'] ?? null;  // get for attribute id or return null

            // dd($attributeId);

            // create new attribute
            $attribute = $this->productRepo->createOrUpdateAttribute([
                'name' => $data['attribute_name'],
                'type' => $type,
            ], $attributeId);

            // clear existing attribute values
            $this->productRepo->clearAttributeValues($attribute);

            // clear existing product attribute values
            $this->productRepo->clearProductAttributeValues($product, $attribute);

            // dd($attribute->toArray());

            // create attribute values
            $labels = $data['label'] ?? [];

            foreach ($labels as $index => $label) {
                // check if label is empty
                if (empty($label))
                    continue;

                // Check if index exists in color_value, otherwise default to null
                $hexCode = $data['color_value'][$index] ?? null;

                // new attribute
                $attributeValue = $this->productRepo->createAttributeValues($attribute->id, [
                    'label' => $label,
                    'color' => ($type === ProductAttributeType::COLOR) ? $hexCode : null,
                ]);

                // attach attribute values to product
                $this->productRepo->createProductAttributeValues(
                    $productId,
                    $attribute->id,
                    $attributeValue->id
                );
            }

            return $product->fresh(['attributeValues',
                'attributeWithValues' => function ($query) use ($product) {
                    $query->WithValuesForProduct($product->id);
                }]);
        });
    }

    public function deleteAttribute(int $attributeId, int $productId): bool
    {
        $product = $this->getProduct($productId);
        $attribute = $this->productRepo->getAttribute($attributeId);

        if ($product && $attribute) {
            return $this->productRepo->deleteAttribute($attribute);
        }

        return false;
    }

    public function deleteAttributeValue(int $attributeValueId, int $attributeId, int $productId): bool
    {
        $product = $this->getProduct($productId);
        $attribute = $this->productRepo->getAttribute($attributeId);
        $attributeValue = $this->productRepo->getAttributeValue($attributeValueId);

        if ($product && $attribute && $attributeValue) {
            return $this->productRepo->deleteAttributeValue($attributeValue);
        }

        return false;
    }
}
