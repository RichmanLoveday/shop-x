<?php

namespace App\Services;

use App\Models\Address;
use App\Models\User;
use App\Repositories\Contracts\AddressRepositoryInterface;
use App\Services\Contracts\AddressServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Override;

class AddressService implements AddressServiceInterface
{
    public function __construct(
        public AddressRepositoryInterface $addressRepo,
    ) {}

    public function createAddress(User $user, array $data): Address
    {
        $data['user_id'] = $user->id;
        return $this->addressRepo->createOrUpdateAddress($data);
    }

    public function updateAddress(User $user, int $id, array $data): Address
    {
        $data['user_id'] = $user->id;
        return $this->addressRepo->createOrUpdateAddress($data, $id);
    }

    public function getAddress(User $user, int $id): Address
    {
        return $this->addressRepo->fetchAddressById($id, $user->id);
    }

    public function allAddress(User $user): Collection
    {
        return $this->addressRepo->fetchAllAddress($user->id);
    }
}
