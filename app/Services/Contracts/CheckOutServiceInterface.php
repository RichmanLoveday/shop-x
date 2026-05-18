<?php

namespace App\Services\Contracts;

use App\Models\User;

interface CheckOutServiceInterface
{
    public function getItems(User $user): array;
}
