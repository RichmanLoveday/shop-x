<?php

namespace App\Services\Contracts\Vendor;

use App\Models\Store;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

interface StoreServiceInterface
{
    public function addStoreDetails(User $vendor, array $data): Store;

    public function uploadStoreBanner(Store $store, UploadedFile $document): string;

    public function uploadStoreLogo(Store $store, UploadedFile $document): string;

    public function getStoreData(int $vendorId): ?Store;

    // public function findStore(string $storeName): Collection;
}