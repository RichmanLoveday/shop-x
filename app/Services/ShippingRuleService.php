<?php

namespace App\Services;

use App\Models\ShippingRule;
use App\Repositories\Contracts\ShippingRuleRepositoryInterface;
use App\Services\Contracts\ShippingRuleServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Override;

class ShippingRuleService implements ShippingRuleServiceInterface
{
    public function __construct(
        public ShippingRuleRepositoryInterface $shippingRuleRepo,
    ) {}

    public function createShippingRule(array $data): ShippingRule
    {
        // dd($data);
        return $this->shippingRuleRepo->createOrUpdateShippingRule($data);
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
        return $this->shippingRuleRepo->createOrUpdateShippingRule($data, $id);
    }

    public function deleteShippingRule(int $id): bool
    {
        $shippingRule = $this->shippingRuleRepo->findShippingRuleOrFail($id);
        return $shippingRule->delete();
    }
}
