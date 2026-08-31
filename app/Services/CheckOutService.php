<?php

namespace App\Services;

use App\Exceptions\CartEmptyException;
use App\Models\Address;
use App\Models\User;
use App\Repositories\Contracts\ShippingRuleRepositoryInterface;
use App\Services\Contracts\User\CartServiceInterface;
use App\Services\Contracts\AddressServiceInterface;
use App\Services\Contracts\CheckOutServiceInterface;
use App\Services\Contracts\ShippingZoneResolverServiceInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use RuntimeException;

class CheckOutService implements CheckOutServiceInterface
{
    public function __construct(
        public CartServiceInterface $cartService,
        public ShippingRuleRepositoryInterface $shippingRepo,
        public ShippingZoneResolverServiceInterface $shippingZoneResolverService,
        public AddressServiceInterface $addressService,
        public ShippingRuleRepositoryInterface $shippingRuleRepo,
    ) {}

    public function getItems(User $user): array
    {
        $cartItems = $this->cartService->getCartItems($user);

        // check if cart items is empty
        if ($cartItems['cartItems']->isEmpty()) {
            throw new CartEmptyException();
        }

        $cartItems['shipping'] = null;

        $address = $this->addressService->getDefaultAddress($user);

        // check if address does not exist
        if (!$address) {
            $cartItems['shipping'] = null;
            $cartItems['shipping_error'] = 'Please set a delivery address';
            return $cartItems;
        }

        // check if shipping method is set already
        return $this->checkIfShippingMethodExist($cartItems, $address);
    }

    // public function getItems(User $user): array
    // {
    //     $cartItems = $this->cartService->getCartItems($user);

    //     // get user default address
    //     $address = $this->addressService->getDefaultAddress($user);

    //     if (!$address) {
    //         $cartItems['shipping'] = null;
    //         $cartItems['shipping_error'] = 'Please set a delivery address';
    //         return $cartItems;
    //     }

    //     // resolve shipping zone for the current user
    //     $resolved = $this->shippingZoneResolverService->resolveByCity($address->city_id);
    //     // $shipping = $this->shippingZoneResolverService->calculatedEstimatedDeliveryCost($resolved);

    //     if (!$shipping['status']) {
    //         $cartItems['shipping'] = null;
    //         $cartItems['shipping_error'] = $shipping['message'];
    //         return $cartItems;
    //     }

    //     $cartItems['shipping'] = [
    //         'id' => $shipping['rule_id'],
    //         'charge' => $shipping['cost'],
    //         'rule_name' => $shipping['rule_name'],
    //         'zone_name' => $shipping['zone_name'],
    //     ];

    //     $cartItems['total'] += $shipping['cost'];

    //     return $cartItems;
    // }

    private function checkIfShippingMethodExist(array $data, Address $address): array
    {
        if (!Session::has('shipping_method')) {
            return $data;
        }

        try {
            $shippingId = Session::get('shipping_method.rule_id');
            $zoneId = Session::get('shipping_method.zone_id');

            // Resolve current address zone
            $resolved = $this->shippingZoneResolverService->resolveByCity($address->city_id);

            // Ensure zone still matches current address
            if (!$resolved['zone'] || $resolved['zone']['id'] !== $zoneId) {
                Session::forget('shipping_method');

                $data['shipping'] = null;
                $data['shipping_error'] = 'Selected shipping method is no longer valid for your current address';

                return $data;
            }

            $shippingMethod = $this->shippingRuleRepo->fetchShippingRuleForZone($shippingId, $zoneId);

            if (!$shippingMethod) {
                Session::forget('shipping_method');

                $data['shipping'] = null;
                $data['shipping_error'] = 'Invalid shipping method selected';

                return $data;
            }

            $charge = $shippingMethod->pivot->override_charge ?? $shippingMethod->charge;

            // update totals
            $data['shipping'] = [
                'id' => $shippingMethod->id,
                'charge' => $charge,
                'name' => $shippingMethod->name,
            ];

            $data['total'] += $charge;
        } catch (\Exception $e) {
            Session::forget('shipping_method');

            Log::error('Shipping details calculation failed: ' . $e->getMessage());

            $data['shipping'] = null;
            $data['shipping_error'] = 'Unable to apply shipping method';
        }

        return $data;
    }
}
