<?php

namespace App\Repositories\Eloquent\Vendor;

use App\Models\Store;
use App\Repositories\Contracts\Vendor\StoreRepositoryInterface;

class StoreRepository implements StoreRepositoryInterface
{
    public function updateCreate(int $vendorId, array $data): Store
    {
        return Store::updateOrCreate(
            ['user_id' => $vendorId],
            $data,
        );
    }

    public function update(Store $store, array $data): bool
    {
        return $store->update($data);
    }

    public function getStore(string $vendorId): ?Store
    {
        return Store::where('user_id', $vendorId)->first();
    }
}
