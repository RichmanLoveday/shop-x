<?php

namespace App\Services\Contracts\Admin;

use App\Models\Store;
use Illuminate\Database\Eloquent\Collection;

interface StoreServiceInterface
{
    public function allStore(): Collection;

    public function findStore(string $storeName): Collection;

    public function getStore(int $id): Store;
}
