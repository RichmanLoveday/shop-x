<?php

namespace App\Services\Admin;

use App\Models\Brand;
use App\Repositories\Contracts\Admin\ProductRepositoryInterface;
use App\Services\Contracts\Admin\BrandServiceInterface;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;

class BrandService extends BaseService implements BrandServiceInterface
{
    public function __construct(
        protected ProductRepositoryInterface $productRepo
    ) {}

    public function addBrand(array $data): Brand
    {
        // dd($data);
        $payload['name'] = $data['name'];
        $payload['is_active'] = isset($data['status']) ? 1 : 0;
        $payload['slug'] = $this->generateSlug($data['name'], fn($slug) => $this->productRepo->checkIfBrandSlugExit($slug));

        // get the brand logo from the file request data
        $document = $data['brand_logo'] ?? Null;

        return DB::transaction(function () use ($payload, $document) {
            $brand = $this->productRepo->createBrand($payload);

            // Handle document upload if provided
            if ($document instanceof UploadedFile) {
                $this->uploadMedia($brand, $document, 'brand_logo');
            }

            return $brand->fresh();
        });
    }

    public function update(int $id, array $data): Brand
    {
        $brand = $this->getBrand($id);

        $payload['name'] = $data['name'];
        $payload['is_active'] = isset($data['status']) ? 1 : 0;
        $payload['slug'] = $brand->name !== $data['name'] ? $this->generateSlug($data['name'], fn($slug) => $this->productRepo->checkIfBrandSlugExit($slug)) : $brand->slug;

        // get the brand logo from the file request data
        $document = $data['brand_logo'] ?? Null;

        return DB::transaction(function () use ($id, $payload, $document) {
            $brand = $this->productRepo->updateBrand($id, $payload);

            // Handle document upload if provided
            if ($document instanceof UploadedFile) {
                $this->uploadMedia($brand, $document, 'brand_logo');
            }

            return $brand->fresh();
        });
    }

    public function allBrands(): LengthAwarePaginator
    {
        return $this->productRepo->getAllBrand();
    }

    public function getBrand(int $id): Brand
    {
        return $this->productRepo->getBrand($id);
    }

    public function delete(int $id): bool
    {
        $brand = $this->getBrand($id);

        return $brand->delete();
    }

    public function findBrand(string $brandName): Collection
    {
        return $this->productRepo->findBrand($brandName);
    }
}
