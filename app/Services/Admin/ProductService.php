<?php

namespace App\Services\Admin;

use App\Models\Product;
use App\Repositories\Contracts\Admin\ProductRepositoryInterface;
use App\Services\Contracts\Admin\ProductServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductService implements ProductServiceInterface
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
        $payload['slug'] = $this->createSlug($data['name']);
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
                $this->uploadThumbnail($product, $document);
            }

            // attach categories
            $product->categories()->sync($data['categories']);

            // attach tags
            $product->tags()->sync($data['tags']);

            return $product->fresh();
        });

        return $this->productRepo->createProduct($payload);
    }

    public function getProduct(int $id): Product
    {
        throw new \Exception('Not implemented');
    }

    public function allProducts(): Collection
    {
        throw new \Exception('Not implemented');
    }

    public function updateProduct(int $id, array $data): Product
    {
        throw new \Exception('Not implemented');
    }

    private function uploadThumbnail(Product $product, $image): string
    {
        $product->clearMediaCollection('product_thumbnail');

        // upload new avatar (Spatie)
        $media = $product
            ->addMedia($image)
            ->usingFileName(uniqid() . '.' . $image->getClientOriginalExtension())
            ->toMediaCollection('product_thumbnail');

        // store avatar path in DB
        $product->thumbnail = $media->getUrl();
        $product->save();

        return $product->thumbnail;
    }

    private function createSlug(string $productName): string
    {
        $slug = Str::slug($productName, '-');
        $originalSlug = $slug;
        $count = 1;

        while ($this->productRepo->checkIfProductSlugExit($slug)) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }
}
