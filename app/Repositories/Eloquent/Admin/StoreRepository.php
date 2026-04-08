<?php

namespace App\Repositories\Eloquent\Admin;

use App\Models\Store;
use App\Repositories\Contracts\Admin\StoreRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class StoreRepository implements StoreRepositoryInterface
{
    public function getStore(int $id): Store
    {
        throw new \Exception('Not implemented');
    }

    public function findStore(string $name): Collection
    {
        $name = trim($name);

        return Store::query()
            ->where('name', 'LIKE', "{$name}%")
            ->get();
    }

    public function getStores(): Collection
    {
        throw new \Exception('Not implemented');
    }
}
