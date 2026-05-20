<?php
namespace App\Services\Contracts;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface AddressServiceInterface
{
    public function createAddress(User $user, array $data): Address;

    public function updateAddress(User $user, int $id, array $data): Address;

 public function getAddress(User $user, int $id): Address;

    public function allAddress(User $user): Collection;
}
