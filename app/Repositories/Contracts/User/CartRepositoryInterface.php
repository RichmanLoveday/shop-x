<?php

namespace App\Repositories\Contracts\User;

use App\Models\Cart;

interface CartRepositoryInterface
{
    public function createOrUpdateCart(array $data, ?int $cartID = null): Cart;

    public function findCartVariantProduct(int $userId, int $productId, ?int $variantId = null): Cart|Null;

    public function getCartItems(int $userId);

    public function findCartItemOrFail(int $cartId, int $userId): Cart;

    public function deleteCartItem(int $cartId, int $userId): bool;

    public function deleteMultipleCartItems(array $cartIds, int $userId): bool;
}
