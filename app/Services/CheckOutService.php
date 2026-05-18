<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\ShippingRuleRepositoryInterface;
use App\Services\Contracts\User\CartServiceInterface;
use App\Services\Contracts\CheckOutServiceInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use RuntimeException;

class CheckOutService implements CheckOutServiceInterface
{
    public function __construct(
        public CartServiceInterface $cartService,
        public ShippingRuleRepositoryInterface $shippingRepo
    ) {}

    public function getItems(User $user): array
    {
        $cartItems = $this->cartService->getCartItems($user);
        $cartItems['shipping'] = null;

        // check if shipping method is set already
        return $this->checkIfShippingMethodExist($cartItems);
    }

    private function checkIfShippingMethodExist(array $data): array
    {
        if (!Session::has('shipping_method')) {
            return $data;
        }

        try {
            $shippingId = Session::get('shipping_method.id');
            $shippingMethod = $this->shippingRepo->findShippingRuleOrFail($shippingId);

            // update main total and shipping 
            $data['shipping'] = [
                'id' => $shippingMethod->id,
                'charge' => $shippingMethod->charge,
            ];

            $data['total'] = $data['total'] + $shippingMethod->charge;
        } catch (\Exception $e) {
            // Delete coupon session if issue occur
            Session::forget('shipping_method');
            Log::error('Shipping details calculation failed: ' . $e->getMessage());
        }

        return $data;
    }
}
