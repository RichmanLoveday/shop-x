<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Contracts\User\CartServiceInterface;
use App\Traits\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            ['cartItems' => $cartItems, 'cartSubTotal' => $cartSubTotal, 'appliedCoupon' => $appliedCoupon] = $this->cartService->getCartItems(Auth::guard('web')->user());
            // dd($appliedCoupon);
            return view('frontend.pages.cart', compact('cartItems', 'cartSubTotal', 'appliedCoupon'));
        } catch (\RuntimeException $e) {
            $this->failed($e->getMessage());
            // return redirect()->route('login');
            return redirect()->back();
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

            return response()->json([
                'status' => true,
                'message' => 'Product added to cart',
                'data' => $cart
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
            ['cartItems' => $cartItems, 'cartSubTotal' => $cartSubTotal] = $this->cartService->updateCartItem($user, $request->id, $request->qty, $request->productType);
            $cartHtml = view('components.frontend.cart-item-component', compact('cartItems'))->render();

            // dd($cartItems->toArray());
            return response()->json([
                'status' => true,
                'message' => 'Cart updated successfully',
                'cart_sub_total' => $cartSubTotal,
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
            ['cartItems' => $cartItems, 'cartSubTotal' => $cartSubTotal] = $this->cartService->removeCartItem($user, $id);
            $cartHtml = view('components.frontend.cart-item-component', compact('cartItems'))->render();

            return response()->json([
                'status' => true,
                'message' => 'Cart item removed successfully',
                'cart_sub_total' => $cartSubTotal,
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
            ['cartItems' => $cartItems, 'cartSubTotal' => $cartSubTotal] = $this->cartService->bulkDeleteCartItems($user, $validated['cart_ids']);
            $cartHtml = view('components.frontend.cart-item-component', compact('cartItems'))->render();

            return response()->json([
                'status' => true,
                'message' => 'Cart items removed successfully',
                'cart_sub_total' => $cartSubTotal,
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
}
