<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Contracts\User\CartServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct(
        protected CartServiceInterface $cartService,
    ) {}

    public function index()
    {
        return view('frontend.pages.cart');
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
}