<?php

namespace App\Repositories\Eloquent;

use App\Models\ShippingRule;
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
}
