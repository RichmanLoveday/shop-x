<?php

namespace App\Services;

use App\Models\Address;
use App\Models\User;
use App\Repositories\Contracts\AddressRepositoryInterface;
use App\Services\Contracts\AddressServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Override;

class AddressService implements AddressServiceInterface
{
    public function __construct(
        public AddressRepositoryInterface $addressRepo,
    ) {}

    public function createAddress(User $user, array $data): Address
    {
        return DB::transaction(function () use ($user, $data) {
            $data['user_id'] = $user->id;

            if (isset($data['is_default']) && $data['is_default']) {
                $this->addressRepo->resetDefaultAddress($user->id);
            }

            return $this->addressRepo->createOrUpdateAddress($data);
        });
    }

    public function updateAddress(User $user, int $id, array $data): Address
    {
        return DB::transaction(function () use ($user, $data, $id) {
            $data['user_id'] = $user->id;

            if (isset($data['is_default']) && $data['is_default']) {
                $this->addressRepo->resetDefaultAddress($user->id);
            }

            return $this->addressRepo->createOrUpdateAddress($data, $id);
        });
    }

    public function getAddress(User $user, int $id): Address
    {
        return $this->addressRepo->fetchAddressById($id, $user->id);
    }

    public function allAddress(User $user): Collection
    {
        return $this->addressRepo->fetchAllAddress($user->id);
    }

    public function setDefault(User $user, int $id): void
    {
        DB::transaction(function () use ($id, $user) {
            $this->addressRepo->resetDefaultAddress($user->id);
            $this->addressRepo->markAsDefault($id);
        });
    }

    public function deleteAddress(User $user, int $id): bool
    {
        $address = $this->addressRepo->fetchAddressById($id, $user->id);
        return $address->delete();
    }
}