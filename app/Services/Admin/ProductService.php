<?php

namespace App\Services\Admin;

use App\Enums\ProductAttributeType;
use App\Enums\ProductFilesStatus;
use App\Enums\ProductType;
use App\Jobs\DeleteDigitalFileJob;
use App\Jobs\ProcessDigitalFileJob;
use App\Models\Admin;
use App\Models\Product;
use App\Models\ProductFile;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\User;
use App\Repositories\Contracts\Admin\ProductRepositoryInterface;
use App\Services\Contracts\Admin\ProductServiceInterface;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Str;
use Pest\Support\Arr;
use Exception;

class ProductService extends BaseService implements ProductServiceInterface
{
    public function __construct(
        protected ProductRepositoryInterface $productRepo,
    ) {}

    public function addProduct(array $data, string $type): Product
    {
        // dd($data);
        if (!ProductType::tryFrom($type)) {
            abort(404, 'Invalid product type.');
        }

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
        $payload['manage_stock'] = isset($data['manage_stock']) ? 'yes' : 'no';
        $payload['stock_status'] = isset($data['in_stock']) && $data['in_stock'] == 'in_stock' ? 1 : 0;
        $payload['status'] = $data['status'];
        $payload['is_featured'] = isset($data['is_featured']) ? 1 : 0;
        $payload['is_hot'] = isset($data['is_hot']) ? 1 : 0;
        $payload['is_new'] = isset($data['is_new']) ? 1 : 0;
        $payload['product_type'] = $type;

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
            isset($data['tags']) ? $product->tags()->sync($data['tags']) : '';

            return $product->fresh();
        });
    }

    public function getProduct(int $id, ProductType|string $type = ProductType::PHYSICAL): Product
    {
        return $this->productRepo->getProduct($id, $type);
    }

    public function allProducts(): LengthAwarePaginator
    {
        return $this->productRepo->getAllProducts();
    }

    public function updateProduct(int $id, ProductType|string $type, array $data): Product
    {
        // dd($data);
        if (!ProductType::tryFrom($type)) {
            abort(404, 'Invalid product type.');
        }
        // check if product exist
        $product = $this->productRepo->getProduct($id, $type);

        // dd($product);

        if (!$product)
            throw new \Exception('Product not found');

        // dd($data);

        $payload['name'] = $data['name'];
        $payload['brand_id'] = $data['brand_id'];
        $payload['short_description'] = $data['short_description'];
        $payload['description'] = $data['long_description'];
        // $payload['sku'] = $data['sku'];
        $payload['price'] = $data['price'];
        $payload['special_price'] = $data['special_price'];
        $payload['special_price_start'] = $data['from_date'];
        $payload['special_price_end'] = $data['end_date'];
        $payload['qty'] = $data['quantity'];
        $payload['manage_stock'] = isset($data['manage_stock']) ? 'yes' : 'no';
        $payload['stock_status'] = isset($data['stock_status']) && $data['stock_status'] == 'in_stock' ? 1 : 0;
        $payload['status'] = $data['status'];
        $payload['is_featured'] = isset($data['is_featured']) ? 1 : 0;
        $payload['is_hot'] = isset($data['is_hot']) ? 1 : 0;
        $payload['is_new'] = isset($data['is_new']) ? 1 : 0;
        $payload['product_type'] = $type;
        $payload['slug'] = $product->name != $data['name'] ? $this->generateSlug($data['name'], fn($slug) => $this->productRepo->checkIfProductSlugExit($slug)) : $product->slug;

        $document = $data['thumbnail'] ?? null;

        // dd($payload);

        return DB::transaction(function () use ($product, $payload, $document, $data) {
            $updatedProduct = $this->productRepo->updateProduct($product, $payload);

            // Handle document upload if provided
            if ($document instanceof UploadedFile) {
                $this->uploadMedia($updatedProduct, $document, 'product_thumbnail', 'thumbnail');
            }

            // attach categories
            $updatedProduct->categories()->sync($data['categories']);

            // attach tags
            isset($data['tags']) ? $updatedProduct->tags()->sync($data['tags']) : '';

            return $updatedProduct->fresh();
        });
    }

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

    public function addProductAttributes(int $productId, array $data, ProductType|string $type = ProductType::PHYSICAL): Product
    {
        // dd($data);
        return DB::transaction(function () use ($productId, $data, $type) {
            // check if product exist
            $product = $this->getProduct($productId, $type);

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

            // regenerate product variants
            $this->regenerateProductVariants($product);

            return $product->fresh(['attributeValues', 'variants', 'attributes',
                'attributeWithValues' => function ($query) use ($product) {
                    $query->WithValuesForProduct($product->id);
                }]);
        });
    }

    public function deleteAttribute(int $attributeId, int $productId, ProductType|string $type = ProductType::PHYSICAL): Product
    {
        $product = $this->getProduct($productId, $type);
        $attribute = $this->productRepo->getAttribute($attributeId);

        if (!$product || !$attribute) {
            throw new \Exception('Either product or attribute not found');
        }

        $this->productRepo->deleteAttribute($attribute);

        $this->regenerateProductVariants($product, false);

        return $product->fresh(['attributeValues', 'variants',
            'attributeWithValues' => function ($query) use ($product) {
                $query->WithValuesForProduct($product->id);
            }]);
    }

    public function deleteAttributeValue(int $attributeValueId, int $attributeId, int $productId, ProductType|string $type = ProductType::PHYSICAL): Product
    {
        // dd($attributeValueId);
        $product = $this->getProduct($productId, $type);
        $attribute = $this->productRepo->getAttribute($attributeId);
        $attributeValue = $this->productRepo->getAttributeValue($attributeValueId);

        if (!$product || !$attribute || !$attributeValue) {
            throw new \Exception('Either product, attribute, attribute value not found');
        }

        $this->productRepo->deleteAttributeValue($attributeValue);

        // regenerate product variants
        $this->regenerateProductVariants($product, false);

        return $product->fresh(['attributeValues', 'variants',
            'attributeWithValues' => function ($query) use ($product) {
                $query->WithValuesForProduct($product->id);
            }]);
    }

    private function regenerateProductVariants(Product $product, bool $requireAttributes = true): void
    {
        // clear existing variants
        $this->clearExistingVariants($product);
        // dd('product variant cleared');

        // get current attribute values group by attributes
        $attributeGroups = $this->getAttributeGroups($product);

        // dd($attributeGroups->toArray());

        // throw error if group is empty
        if ($attributeGroups->isEmpty()) {
            if ($requireAttributes) {
                throw new \Exception('No attribute values found for variant generation');
            }
            return;
        }

        // make combinations
        $combination = $this->cartesianProduct($attributeGroups);
        // dd($combination);

        $this->createVariantsCombinations($product, $combination);
    }

    private function clearExistingVariants(Product $product): void
    {
        foreach ($product->variants as $variant) {
            $this->productRepo->clearExistingProductVariantAttributeValue($variant->id);
            $variant->delete();
        }
    }

    private function getAttributeGroups(Product $product): SupportCollection
    {
        $groupedAttributes = $this->productRepo->getGroupProductAttributes($product->id);

        $attributeGroups = collect();

        foreach ($groupedAttributes as $attribute => $items) {
            $attributeValueIds = $items->pluck('attribute_value_id')->toArray();
            $attributeValues = $this->productRepo->getAttributeValues($attributeValueIds);
            $attributeGroups->push($attributeValues);
        }

        return $attributeGroups;
    }

    private function cartesianProduct(SupportCollection $attributeGroups): array
    {
        $result = [[]];

        foreach ($attributeGroups as $attributeValues) {
            $temp = [];

            foreach ($result as $resultItem) {
                foreach ($attributeValues as $attributeValue) {
                    $temp[] = array_merge($resultItem, [$attributeValue]);
                }
            }

            $result = $temp;
        }

        return $result;
    }

    private function createVariantsCombinations(Product $product, array $combinations)
    {
        // dd($combinations);
        foreach ($combinations as $combination) {
            $variant = $this->createSingleVariant($product, $combination);

            // Prepare pivot data with attribute_id + attribute_value_id
            $pivotData = collect($combination)->mapWithKeys(function ($attrValue) {
                return [
                    $attrValue->id => [
                        'attribute_id' => $attrValue->attribute_id
                    ]
                ];
            })->toArray();

            // Attach with extra pivot data
            $variant->attributeValues()->attach($pivotData);
        }
    }

    private function createSingleVariant(Product $product, array $combination): ProductVariant
    {
        // dd($combination);
        $variantName = collect($combination)
            ->pluck('label')
            ->map(fn($label) => strtoupper(trim($label)))
            ->implode('/');

        // Generate SKU
        $skuPart = collect($combination)
            ->pluck('label')
            ->map(fn($label) => strtoupper(substr(trim($label), 0, 3)))
            ->implode('');

        return $this->productRepo->createOrUpdateProductVariant([
            'product_id' => $product->id,
            'name' => $variantName,
            'price' => 0,
            'sku' => $product->sku . '-' . $skuPart,
            'qty' => 0,
            'stock_status' => true,
            'is_active' => true,
        ]);
    }

    public function updateProductVariant(int $productId, array $data, ProductType|string $type = ProductType::PHYSICAL): Product
    {
        $product = $this->getProduct($productId, $type);
        $variantId = $data['variant_id'] ?? null;

        if (!$product || !$variantId) {
            throw new \Exception('Product or Variant ID is required');
        }

        $variant = $this->productRepo->getProductVariant($variantId);

        // Security check: Make sure variant belongs to this product
        if (!$variant || $variant->product_id !== $product->id) {
            throw new \Exception('Variant not found or does not belong to this product');
        }

        // Build clean payload
        $payload = [
            'product_id' => $product->id,
            'sku' => $data['variant_sku'] ?? $variant->sku,
            'price' => (float) ($data['variant_price'] ?? 0),
            'special_price' => $data['variant_special_price'] ? (float) $data['variant_special_price'] : null,
            'manage_stock' => isset($data['variant_manage_stock']) ? 1 : 0,
            'qty' => (int) ($data['variant_quantity'] ?? 0),
            'stock_status' => $data['variant_stock_status'] === 'in_stock' ? 1 : 0,
            'is_active' => $data['variant_is_active'],
            'is_default' => $data['variant_is_default'],
        ];

        // If this variant is being set as default, reset all others first
        if (!empty($payload['is_default'])) {
            $this->productRepo->resetDefaultVariants($product->id, $variantId);
        }

        $this->productRepo->createOrUpdateProductVariant($payload, $variantId);

        return $product->fresh('variants');
    }
}
