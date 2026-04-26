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

}
