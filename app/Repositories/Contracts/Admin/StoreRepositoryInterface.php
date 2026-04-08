<?php
namespace App\Repositories\Contracts\Admin;

use App\Models\Store;
use Illuminate\Database\Eloquent\Collection;

interface StoreRepositoryInterface
{
    public function getStores(): Collection;

    public function findStore(string $name): Collection;

    public function getStore(int $id): Store;
}
