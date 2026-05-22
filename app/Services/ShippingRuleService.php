<?php

namespace App\Services;

use App\Models\ShippingRule;
use App\Models\User;
use App\Repositories\Contracts\User\CartRepositoryInterface;
use App\Repositories\Contracts\ShippingRuleRepositoryInterface;
use App\Services\Contracts\User\CartServiceInterface;
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

            // update shipping rule
            return $this->shippingRuleRepo->createOrUpdateShippingRule($data, $id);
        });
    }

    public function deleteShippingRule(int $id): bool
    {
        $shippingRule = $this->shippingRuleRepo->findShippingRuleOrFail($id);
        return $shippingRule->delete();
    }

    public function saveShippingMethod(User $user, int $shippingId): array
    {
        if (!$user) {
            throw new RuntimeException('Please login to add product to cart');
        }

        $shippingMethod = $this->shippingRuleRepo->findShippingRuleOrFail($shippingId);

        // save shipping rule id in session
        Session::put('shipping_method', [
            'id' => $shippingMethod->id,
        ]);

        $cartItems = $this->cartService->getCartItems($user);

        $total = $cartItems['total'] + $shippingMethod->charge;

        return [
            'total' => $total,
            'shipping_charge' => $shippingMethod->charge,
        ];
    }
}