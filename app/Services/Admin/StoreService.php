<?php

namespace App\Services\Admin;

use App\Models\Store;
use App\Repositories\Eloquent\Admin\StoreRepository;
use App\Services\Contracts\Admin\StoreServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class StoreService implements StoreServiceInterface
{
    public function __construct(
        protected StoreRepository $storeRepo
    ) {}

    public function allStore(): Collection
    {
        throw new \Exception('Not implemented');
    }

    public function getStore(int $id): Store
    {
        throw new \Exception('Not implemented');
    }

    public function findStore(string $storeName): Collection
    {
        return $this->storeRepo->findStore($storeName);
    }
}
