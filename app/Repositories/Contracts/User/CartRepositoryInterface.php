<?php

namespace App\Repositories\Contracts\User;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Collection;

interface CartRepositoryInterface
{
    public function createOrUpdateCart(array $data, ?int $cartID = null): Cart;

    public function findCartVariantProduct(int $userId, int $productId, ?int $variantId = null): Cart|Null;

    public function getCartItems(int $userId);

    public function getCartCount(int $userId): int;

    public function findCartItemOrFail(int $cartId, int $userId): Cart;

    public function deleteCartItem(int $cartId, int $userId): bool;

    public function deleteMultipleCartItems(array $cartIds, int $userId): bool;

    public function fetchCartItemsByStore(int $userId): Collection;
}