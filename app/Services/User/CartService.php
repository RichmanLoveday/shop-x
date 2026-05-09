<?php

namespace App\Services\User;

use App\Models\Cart;
use App\Models\User;
use App\Repositories\Contracts\User\CartRepositoryInterface;
use App\Repositories\Contracts\User\ProductRepositoryInterface;
use App\Services\Contracts\User\CartServiceInterface;
use Illuminate\Support\Facades\Auth;
use RuntimeException;

class CartService implements CartServiceInterface
{
    public function __construct(
        protected ProductRepositoryInterface $productRepo,
        protected CartRepositoryInterface $cartRepo,
    ) {}

    public function addToCart(?User $user, int $productID, string $type, int $quantity, array|null $options, ?int $variant = null): Cart
    {
        // check if user is logged in
        if (!$user) {
            throw new RuntimeException('Please login to add product to cart');
        }

        // check if product exist, and type is accurate
        $product = $this->productRepo->getProduct($productID, $type);
        // dd($product);

        $productVariant = null;
        // check if variant is available
        if ($variant) {
            $productVariant = $this->productRepo->findProductVariant($productID, $variant);

            // check if product variant exist
            if (!$productVariant) {
                throw new RuntimeException('Invalid variant selected');
            }
        }

        // get stock, status, manage stock columns
        $stock = $variant ? $productVariant->qty : $product->qty;
        $status = $variant ? $productVariant->stock_status : $product->stock_status;
        $manageStock = $variant ? $productVariant->manage_stock : $product->manage_stock;

        // check stock status
        if (!$status) {
            throw new RuntimeException('Product is out of stock');
        }

        // check quantity
        if (($manageStock == 1 || $manageStock == 'yes') && $stock == 0) {
            throw new RuntimeException('Product is out of stock');
        }

        // check quantity
        if (($manageStock == 1 || $manageStock == 'yes') && $stock < $quantity) {
            throw new RuntimeException("Not enough product in stock. Available: {$stock}");
        }

        // check for quantity change
        ['cartId' => $cartId, 'qty' => $qty] = $this->checkQuantityChange($user, $productID, $variant, $quantity, $stock);

        $payload['product_id'] = $productID;
        $payload['qty'] = $qty;
        $payload['name'] = $product->name;
        $payload['user_id'] = $user->id;
        $payload['product_variant_id'] = $variant;
        $payload['options'] = $options;

        // store product in cart
        $cart = $this->cartRepo->createOrUpdateCart($payload, $cartId);

        return $cart;
    }


    private function checkQuantityChange(User $user, int $productID, ?int $variant, int $quantity, int $stock): array
    {
        $cart = $this->cartRepo->findCartVariantProduct($user->id, $productID, $variant);

        $currentQty = $cart ? $cart->qty : 0;
        $newTotal = $currentQty + $quantity;

        // validate new qty to stock
        if ($newTotal > $stock) {
            $allowed = $stock - $currentQty;

            throw new RuntimeException(
                "You already have {$currentQty} in cart. Only {$stock} available. You can add {$allowed} more."
            );
        }

        return [
            'cartId' => $cart?->id,
            'qty' => $newTotal,
        ];
    }
}
