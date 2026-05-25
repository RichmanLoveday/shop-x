<?php

namespace App\Repositories\Eloquent;

use App\Models\ShippingRule;
use App\Models\ShippingZone;
use App\Repositories\Contracts\ShippingRuleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Override;

class ShippingRuleRepository implements ShippingRuleRepositoryInterface
{
    public function createOrUpdateShippingRule(array $data, ?int $id = null): ShippingRule
    {
        return ShippingRule::query()
            ->updateOrCreate(['id' => $id], $data);
    }

    public function fetchAllShippingRules(): LengthAwarePaginator
    {
        return ShippingRule::query()
            ->latest()
            ->paginate(25);
    }

    public function findShippingRuleOrFail(int $id): ShippingRule
    {
        return ShippingRule::query()
            ->where('id', $id)
            ->firstOrFail();
    }

    public function resetFallbackShippingRule(): void
    {
        ShippingRule::query()
            ->where('is_fallback', true)
            ->update(['is_fallback' => false]);
    }

    public function fetchFallbackRule(): ?ShippingRule
    {
        return ShippingRule::query()
            ->where([
                'is_fallback' => true,
                'is_active' => true,
            ])
            ->first();
    }

    public function fetchShippingRuleForZone(int $shippingRuleId, int $zoneId): ?ShippingRule
    {
        return ShippingZone::query()
            ->find($zoneId)
            ?->shippingRules()
            ->where('shipping_rule_id', $shippingRuleId)
            ->first();
    }
}
