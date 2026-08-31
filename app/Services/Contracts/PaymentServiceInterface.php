<?php

namespace App\Services\Contracts;

use App\Models\User;

interface PaymentServiceInterface
{
    public function getItems(User $user): array;
}
