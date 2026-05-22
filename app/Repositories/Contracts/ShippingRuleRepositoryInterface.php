<?php

namespace App\Repositories\Contracts;

use App\Models\ShippingRule;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ShippingRuleRepositoryInterface
{
    public function createOrUpdateShippingRule(array $data, ?int $id = null): ShippingRule;

    public function fetchAllShippingRules(): LengthAwarePaginator;

    public function findShippingRuleOrFail(int $id): ShippingRule;

    public function resetFallbackShippingRule(): void;

    public function fetchFallbackRule(): ?ShippingRule;
}