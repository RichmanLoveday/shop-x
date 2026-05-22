<?php

namespace App\Repositories\Contracts;

use App\Models\Address;
use Illuminate\Database\Eloquent\Collection;

interface AddressRepositoryInterface
{
    public function createOrUpdateAddress(array $data, ?int $id = null): Address;

    public function fetchAddressById(int $id, int $userId): Address;

    public function fetchAllAddress(int $userId): Collection;

    public function resetDefaultAddress(int $userId): void;

      public function markAsDefault(int $id): void;

}
