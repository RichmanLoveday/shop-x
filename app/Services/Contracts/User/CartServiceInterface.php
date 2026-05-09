<?php

namespace App\Services\Contracts\User;

use App\Models\Cart;
use App\Models\User;

interface CartServiceInterface
{
    public function addToCart(?User $user, int $productID, string $type, int $quantity, array|null $options, ?int $variant = null): Cart;
}
