<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Contracts\User\CartServiceInterface;
use App\Traits\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    use Alert;

    public function __construct(
        protected CartServiceInterface $cartService,
    ) {}

    public function index()
    {
        try {
            $user = Auth::guard('web')->user();
            [
                'cartItems' => $cartItems,
                'cartSubTotal' => $cartSubTotal,
                'appliedCoupon' => $appliedCoupon,
                'total' => $total
            ] = $this->cartService->getCartItems($user);

            // dd($appliedCoupon);
            return view('frontend.pages.cart', compact('cartItems', 'cartSubTotal', 'appliedCoupon', 'total'));
        } catch (\RuntimeException $e) {
            $this->failed($e->getMessage());
            return redirect()->route('login');
        } catch (\Exception $e) {
            logger()->error('Failed to load cart items: ' . $e->getMessage());
            $this->failed('Failed to load cart items');
            return redirect()->back();
        }
    }

    public function addToCart(Request $request)
    {
        // dd($request->all());
        try {
            $user = Auth::guard('web')->user();

            $cart = $this->cartService->addToCart(
                $user,
                $request->product_id,
                $request->type,
                $request->quantity,
                $request->options ?? null,
                $request->variant ?? null
            );

            $cartCount = $this->cartService->getCartCount($user);

            return response()->json([
                'status' => true,
                'message' => 'Product added to cart',
                'data' => [
                    'cart' => $cart,
                    'cart_count' => $cartCount,
                ],
            ]);
        } catch (\RuntimeException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong'
            ], 500);
        }
    }

    public function updateCart(Request $request)
    {
        try {
            $user = Auth::guard('web')->user();
            [
                'cartItems' => $cartItems,
                'cartSubTotal' => $cartSubTotal,
                'appliedCoupon' => $appliedCoupon,
                'total' => $total
            ] = $this->cartService->updateCartItem($user, $request->id, $request->qty, $request->productType);
            $cartHtml = view('components.frontend.cart-item-component', compact('cartItems'))->render();

            // dd($cartItems->toArray());
            return response()->json([
                'status' => true,
                'message' => 'Cart updated successfully',
                'cart_sub_total' => $cartSubTotal,
                'total' => $total,
                'appliedCoupon' => $appliedCoupon,
                'html' => $cartHtml
            ]);
        } catch (\RuntimeException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong'
            ], 500);
        }
    }

    public function removeCartItem(int $id)
    {
        try {
            $user = Auth::guard('web')->user();
            [
                'cartItems' => $cartItems,
                'cartSubTotal' => $cartSubTotal,
                'appliedCoupon' => $appliedCoupon,
                'total' => $total
            ] = $this->cartService->removeCartItem($user, $id);
            $cartCount = $this->cartService->getCartCount($user);
            $cartHtml = view('components.frontend.cart-item-component', compact('cartItems'))->render();

            return response()->json([
                'status' => true,
                'message' => 'Cart item removed successfully',
                'cart_sub_total' => $cartSubTotal,
                'total' => $total,
                'cart_count' => $cartCount,
                'appliedCoupon' => $appliedCoupon,
                'html' => $cartHtml
            ]);
        } catch (\RuntimeException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong'
            ], 500);
        }
    }

    public function bulkDeleteCartItems(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'cart_ids' => 'required|array',
            'cart_ids.*' => 'integer|exists:carts,id',
        ]);

        try {
            $user = Auth::guard('web')->user();
            [
                'cartItems' => $cartItems,
                'cartSubTotal' => $cartSubTotal,
                'appliedCoupon' => $appliedCoupon,
                'total' => $total
            ] = $this->cartService->bulkDeleteCartItems($user, $validated['cart_ids']);
            $cartCount = $this->cartService->getCartCount($user);
            $cartHtml = view('components.frontend.cart-item-component', compact('cartItems'))->render();

            return response()->json([
                'status' => true,
                'message' => 'Cart item removed successfully',
                'cart_sub_total' => $cartSubTotal,
                'total' => $total,
                'cart_count' => $cartCount,
                'appliedCoupon' => $appliedCoupon,
                'html' => $cartHtml
            ]);
        } catch (\RuntimeException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong'
            ], 500);
        }
    }

    public function applyCoupon(Request $request)
    {
        $validated = $request->validate([
            'coupon' => 'required|string',
        ]);

        try {
            $user = Auth::guard('web')->user();
            $result = $this->cartService->applyCoupon($user, $validated['coupon']);

            return response()->json([
                'status' => true,
                'message' => 'Coupon applied successfully',
                'data' => $result
            ]);
        } catch (\RuntimeException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong'
            ], 500);
        }
    }

    public function removeCoupon()
    {
        try {
            Session::forget('coupon');

            ['cartItems' => $cartItems, 'cartSubTotal' => $cartSubTotal, 'appliedCoupon' => $appliedCoupon, 'total' => $total] = $this->cartService->getCartItems(Auth::guard('web')->user());
            $cartHtml = view('components.frontend.cart-item-component', compact('cartItems'))->render();

            // dd($cartItems->toArray());
            return response()->json([
                'status' => true,
                'message' => 'Coupon Removed successfully',
                'cart_sub_total' => $cartSubTotal,
                'total' => $total,
                'html' => $cartHtml
            ]);
        } catch (\RuntimeException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong'
            ], 500);
        }
    }
}