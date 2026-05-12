<?php

namespace App\Repositories\Eloquent\User;

use App\Models\Cart;
use App\Repositories\Contracts\User\CartRepositoryInterface;
use Override;

class CartRepository implements CartRepositoryInterface
{
    public function createOrUpdateCart(array $data, ?int $cartID = null): Cart
    {
        return Cart::query()
            ->with(['product', 'variant'])
            ->updateOrCreate([
                'id' => $cartID,
            ], $data);
    }

    public function findCartVariantProduct(int $userId, int $productId, ?int $variantId = null): Cart|Null
    {
        return Cart::query()
            ->where('user_id', $userId)
            ->where('product_id', $productId)
            ->when($variantId, function ($q) use ($variantId) {
                $q->where('product_variant_id', $variantId);
            }, function ($q) {
                $q->whereNull('product_variant_id');
            })
            ->first();
    }

    public function getCartItems(int $userId)
    {
        return Cart::query()
            ->with(['product', 'variant'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function findCartItemOrFail(int $cartId, int $userId): Cart
    {
        return Cart::with([
            'product',
        ])
            ->whereKey($cartId)
            ->where('user_id', $userId)
            ->firstOrFail();
    }

    public function deleteCartItem(int $cartId, int $userId): bool
    {
        $cartItem = Cart::query()
            ->whereKey($cartId)
            ->where('user_id', $userId)
            ->first();

        if (!$cartItem) {
            return false;
        }

        return $cartItem->delete();
    }
}