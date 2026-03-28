<?php

namespace App\Repositories\Contracts\Vendor;

use App\Models\Store;

interface StoreRepositoryInterface
{
    public function updateCreate(int $vendorId, array $data): Store;

    public function update(Store $store, array $data): bool;

    public function getStore(string $vendorId): ?Store;
}