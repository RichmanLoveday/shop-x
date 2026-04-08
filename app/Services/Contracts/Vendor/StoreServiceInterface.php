<?php

namespace App\Services\Contracts\Vendor;

use App\Models\Store;
use App\Models\User;
use Illuminate\Http\UploadedFile;

interface StoreServiceInterface
{
    public function addStoreDetails(User $vendor, array $data): Store;

    public function uploadStoreBanner(Store $store, UploadedFile $document): string;

    public function uploadStoreLogo(Store $store, UploadedFile $document): string;

    public function getStoreData(int $vendorId): ?Store;
}
