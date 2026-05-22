<?php

namespace App\Repositories\Eloquent;

use App\Models\Address;
use App\Models\User;
use App\Repositories\Contracts\AddressRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Override;

class AddressRepository implements AddressRepositoryInterface
{
    public function createOrUpdateAddress(array $data, ?int $id = null): Address
    {
        return Address::query()
            ->updateOrCreate(['id' => $id], $data);
    }

    public function resetDefaultAddress(int $userId): void
    {
        Address::query()
            ->where('user_id', $userId)
            ->update(['is_default' => false]);
    }

    public function fetchAddressById(int $id, int $userId): Address
    {
        return Address::query()
            ->where(['id' => $id, 'user_id' => $userId])
            ->firstOrFail();
    }

    public function fetchAllAddress(int $userId): Collection
    {
        return Address::query()
            ->with(['city', 'state'])
            ->where('user_id', $userId)
            ->latest()
            ->get();
    }

    public function markAsDefault(int $id): void
    {
        Address::query()
            ->where('id', $id)
            ->update([
                'is_default' => true
            ]);
    }
}
