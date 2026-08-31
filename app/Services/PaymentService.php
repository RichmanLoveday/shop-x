<?php

namespace App\Services;

use App\Exceptions\CartEmptyException;
use App\Exceptions\InvalidShippingMethodException;
use App\Exceptions\MissingDeliveryAddressException;
use App\Exceptions\MissingShippingMethodException;
use App\Models\Address;
use App\Models\User;
use App\Repositories\Contracts\ShippingRuleRepositoryInterface;
use App\Services\Contracts\User\CartServiceInterface;
use App\Services\Contracts\AddressServiceInterface;
use App\Services\Contracts\PaymentServiceInterface;
use App\Services\Contracts\ShippingZoneResolverServiceInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use RuntimeException;

class PaymentService implements PaymentServiceInterface
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
            throw new MissingDeliveryAddressException('Please set a delivery address');
        }

        // check if shipping method is set already
        return $this->checkIfShippingMethodExist($cartItems, $address);
    }

    private function checkIfShippingMethodExist(array $data, Address $address): array
    {
        if (!Session::has('shipping_method')) {
            throw new MissingShippingMethodException('Please select a shipping method');
        }

        $shippingId = Session::get('shipping_method.rule_id');
        $zoneId = Session::get('shipping_method.zone_id');

        // Resolve current address zone
        $resolved = $this->shippingZoneResolverService->resolveByCity($address->city_id);

        // Ensure zone still matches current address
        if (!$resolved['zone'] || $resolved['zone']['id'] !== $zoneId) {
            Session::forget('shipping_method');
            throw new InvalidShippingMethodException('Selected shipping method is no longer valid');
        }

        $shippingMethod = $this->shippingRuleRepo->fetchShippingRuleForZone($shippingId, $zoneId);

        if (!$shippingMethod) {
            Session::forget('shipping_method');
            throw new InvalidShippingMethodException('Invalid shipping method selected');
        }

        $charge = $shippingMethod->pivot->override_charge ?? $shippingMethod->charge;

        // update totals
        $data['shipping'] = [
            'id' => $shippingMethod->id,
            'charge' => $charge,
            'name' => $shippingMethod->name,
        ];

        $data['total'] += $charge;

        return $data;
    }
}