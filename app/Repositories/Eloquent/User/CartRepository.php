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
}
