<?php

namespace App\Services;

use App\Models\ShippingRule;
use App\Models\User;
use App\Repositories\Contracts\User\CartRepositoryInterface;
use App\Repositories\Contracts\ShippingRuleRepositoryInterface;
use App\Repositories\Contracts\ShippingZoneRepositoryInterface;
use App\Services\Contracts\User\CartServiceInterface;
use App\Services\Contracts\AddressServiceInterface;
use App\Services\Contracts\ShippingRuleServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Override;
use RuntimeException;

class ShippingRuleService implements ShippingRuleServiceInterface
{
    public function __construct(
        public ShippingRuleRepositoryInterface $shippingRuleRepo,
        public ShippingZoneRepositoryInterface $shippingZoneRepo,
        public AddressServiceInterface $addressService,
        public CartServiceInterface $cartService,
        public CartRepositoryInterface $cartRepo,
    ) {}

    public function createShippingRule(array $data): ShippingRule
    {
        return DB::transaction(function () use ($data) {
            // check if fallback column exist
            if (isset($data['is_fallback']) && $data['is_fallback']) {
                // reset shipping fallback
                $this->shippingRuleRepo->resetFallbackShippingRule();
            }

            // add new shipping rule
            return $this->shippingRuleRepo->createOrUpdateShippingRule($data);
        });
    }

    public function allShippingRules(): LengthAwarePaginator
    {
        return $this->shippingRuleRepo->fetchAllShippingRules();
    }

    public function getShippingRule(int $id): ShippingRule
    {
        return $this->shippingRuleRepo->findShippingRuleOrFail($id);
    }

    public function updateShippingRule(int $id, array $data): ShippingRule
    {
        return DB::transaction(function () use ($data, $id) {
            // check if fallback column exist
            if (isset($data['is_fallback']) && $data['is_fallback']) {
                // reset shipping fallback
                $this->shippingRuleRepo->resetFallbackShippingRule();
            }

            // if is_fallback is not set, ensure to reset the fallback column to false
            if (!isset($data['is_fallback'])) {
                $data['is_fallback'] = false;
            }

            // update shipping rule
            return $this->shippingRuleRepo->createOrUpdateShippingRule($data, $id);
        });
    }

    public function deleteShippingRule(int $id): bool
    {
        $shippingRule = $this->shippingRuleRepo->findShippingRuleOrFail($id);
        return $shippingRule->delete();
    }

    public function saveShippingMethod(User $user, int $shippingRuleId, int $zoneId): array
    {
        if (!$user) {
            throw new RuntimeException('Please login to add product to cart');
        }

        // get address of user
        $address = $this->addressService->getDefaultAddress($user);

        if (!$address) {
            return [
                'shipping' => null,
                'shipping_error' => 'Please set a delivery address',
            ];
        }

        // dd($shippingRuleId, $zoneId);
        $shippingMethod = $this->shippingRuleRepo->fetchShippingRuleForZone($shippingRuleId, $zoneId);

        // dd($shippingMethod->toArray());
        // handle missing rule
        if (!$shippingMethod) {
            return [
                'shipping' => null,
                'shipping_error' => 'Invalid shipping method selected',
            ];
        }

        $charge = $shippingMethod->pivot->override_charge ?? $shippingMethod->charge;

        // dd($charge);

        // save in session
        Session::put('shipping_method', [
            'rule_id' => $shippingMethod->id,
            'zone_id' => $zoneId,
            // 'charge' => $charge,
        ]);

        $cartItems = $this->cartService->getCartItems($user);

        $total = $cartItems['total'] + $charge;

        return [
            'total' => $total,
            'shipping_charge' => $charge,
            'shipping_rule' => [
                'id' => $shippingMethod->id,
                'name' => $shippingMethod->name,
            ],
        ];
    }
}
