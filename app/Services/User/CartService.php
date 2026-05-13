<?php

namespace App\Services\User;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\User;
use App\Repositories\Contracts\User\CartRepositoryInterface;
use App\Repositories\Contracts\User\ProductRepositoryInterface;
use App\Repositories\Contracts\CouponRepositoryInterface;
use App\Services\Contracts\User\CartServiceInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Override;
use RuntimeException;

class CartService implements CartServiceInterface
{
    public function __construct(
        protected ProductRepositoryInterface $productRepo,
        protected CartRepositoryInterface $cartRepo,
        protected CouponRepositoryInterface $couponRepo,
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

    public function getCartItems(?User $user): array
    {
        if (!$user) {
            throw new RuntimeException('Please login to view cart items');
        }

        $cartItems = $this->cartRepo->getCartItems($user->id);
        $cartSubTotal = $this->calculateCartSubTotal($cartItems);

        $data = [
            'cartItems' => $cartItems,
            'cartSubTotal' => $cartSubTotal,
            'appliedCoupon' => null,
        ];

        // check if coupon exist in session
        if (Session::has('coupon')) {
            try {
                $couponId = Session::get('coupon.id');
                $coupon = $this->couponRepo->findCouponOrFail($couponId);

                $discount = $this->validateAndCalculateCouponDiscount($coupon, $cartSubTotal);

                $data['appliedCoupon'] = [
                    'discount' => $discount,
                    'coupon_type' => $coupon->is_percent ? '%' : 'Fixed',
                    'coupon_value' => $coupon->value,
                    'cart_sub_total' => $cartSubTotal,
                    'total' => $cartSubTotal - $discount,
                ];
            } catch (\Exception $e) {
                // Delete coupon session if issue occur
                Session::forget('coupon');
                $data['appliedCoupon'] = null;
            }
        }

        return $data;
    }

    public function updateCartItem(?User $user, int $cartId, int $qty, string $productType): array
    {
        if (!$user) {
            throw new RuntimeException('Please login to add product to cart');
        }

        // check if cart and product exist
        $cartItem = $this->cartRepo->findCartItemOrFail($cartId, $user->id);
        $product = $this->productRepo->getProduct($cartItem->product_id, $productType);
        $productPriceQty = $cartItem->variant_or_product_and_stock;

        // dd($productPriceQty);

        // check if product is active
        if (!$productPriceQty['is_active']) {
            throw new RuntimeException('Product is not active');
        }

        // check if product is out of stock
        if (!$productPriceQty['in_stock']) {
            throw new RuntimeException('Product is out of stock');
        }

        // check if product quantity is sufficient
        if ($productPriceQty['qty'] !== 'Unlimited' && $qty > $productPriceQty['qty']) {
            throw new RuntimeException("Only {$productPriceQty['qty']} items available in stock");
        }

        // update cart item with new quantity
        $cartItem = $this->cartRepo->createOrUpdateCart([
            'qty' => $qty,
        ], $cartItem->id);

        $cartItems = $this->cartRepo->getCartItems($cartItem->user_id);
        $cartSubTotal = $this->calculateCartSubTotal($cartItems);

        return [
            'cartItems' => $cartItems,
            'cartSubTotal' => $cartSubTotal,
        ];
    }

    public function removeCartItem(?User $user, int $cartId): array
    {
        if (!$user) {
            throw new RuntimeException('Please login to add product to cart');
        }

        // check if cart and product exist
        $cartItem = $this->cartRepo->findCartItemOrFail($cartId, $user->id);

        // delete cart item
        $this->cartRepo->deleteCartItem($cartItem->id, $user->id);

        $cartItems = $this->cartRepo->getCartItems($cartItem->user_id);
        $cartSubTotal = $this->calculateCartSubTotal($cartItems);

        return [
            'cartItems' => $cartItems,
            'cartSubTotal' => $cartSubTotal,
        ];
    }

    public function bulkDeleteCartItems(?User $user, array $cartIds): array
    {
        if (!$user) {
            throw new RuntimeException('Please login to add product to cart');
        }

        // delete cart items
        $this->cartRepo->deleteMultipleCartItems($cartIds, $user->id);

        $cartItems = $this->cartRepo->getCartItems($user->id);
        $cartSubTotal = $this->calculateCartSubTotal($cartItems);

        return [
            'cartItems' => $cartItems,
            'cartSubTotal' => $cartSubTotal,
        ];
    }

    private function calculateCartSubTotal(Collection $cartItems): float
    {
        $cartSubTotal = 0;

        foreach ($cartItems as $item) {
            $variantOrProductPrice = $item->variant_or_product_and_stock;
            $isOutOfStock = !$variantOrProductPrice['in_stock'];
            $isActive = $variantOrProductPrice['is_active'];

            if (!$isOutOfStock && $isActive) {
                $cartSubTotal += $variantOrProductPrice['price'] * $item->qty;
            }
        }

        return $cartSubTotal;
    }

    public function applyCoupon(?User $user, string $code): array
    {
        if (!$user) {
            throw new RuntimeException('Please login to add product to cart');
        }

        // check if coup exist and is valid
        $coupon = $this->couponRepo->findCouponByCode($code);
        $cartItems = $this->cartRepo->getCartItems($user->id);
        $cartSubTotal = $this->calculateCartSubTotal($cartItems);

        // dd($coupon);

        // validate coupon
        $discount = $this->validateAndCalculateCouponDiscount($coupon, $cartSubTotal);
        $total = $cartSubTotal - $discount;  // get cart total

        // store data in session
        Session::put('coupon', [
            'id' => $coupon->id,
        ]);

        return [
            'discount' => $discount,
            'coupon_type' => $coupon->is_percent ? '%' : 'Fixed',
            'coupon_value' => $coupon->value,
            'cart_sub_total' => $cartSubTotal,
            'total' => $total,
        ];
    }

    private function validateAndCalculateCouponDiscount(?Coupon $coupon, int|float $cartSubTotal): int|float
    {
        if (!$coupon) {
            throw new RuntimeException('Invalid coupon code');
        }

        // check if coupon is active
        if (!$coupon->is_active) {
            throw new RuntimeException('Coupon code is not active');
        }

        $startDate = Carbon::parse($coupon->start_date)->startOfDay();
        $expiryDate = Carbon::parse($coupon->end_date)->endOfDay();

        // Now compare object to object accurately
        if (now()->gt($expiryDate) || now()->lt($startDate)) {
            throw new RuntimeException('Coupon code has expired');
        }

        // check if cart total is greater than min spend of coupon
        if ($cartSubTotal < $coupon->minimum_spend) {
            throw new RuntimeException("Cart total must be at least {$coupon->minimum_spend} to apply this coupon");
        }

        // check if cart total is greater than max spend
        if ($cartSubTotal > $coupon->maximum_spend) {
            throw new RuntimeException("Cart total must not be greater than {$coupon->maximum_spend} to apply this coupon");
        }

        // check if user can use coupon

        // calculate discount amount
        $discount = $coupon->is_percent ? $cartSubTotal * ($coupon->value / 100) : $coupon->value;

        // check if discount doest not exceed to negative value
        $discount = min($discount, $cartSubTotal);

        return $discount;
    }
}
