<?php

namespace App\Services\Contracts\User;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface CartServiceInterface
{
    public function addToCart(?User $user, int $productID, string $type, int $quantity, array|null $options, ?int $variant = null): Cart;

    public function getCartItems(?User $user): array;

    public function updateCartItem(?User $user, int $cartId, int $qty, string $productType): array;

    public function removeCartItem(?User $user, int $cartId): array;

    public function bulkDeleteCartItems(?User $user, array $cartIds): array;

    public function applyCoupon(?User $user, string $code): array;
}