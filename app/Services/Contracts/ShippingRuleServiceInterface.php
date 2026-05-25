<?php

namespace App\Services\Contracts;

use App\Models\ShippingRule;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ShippingRuleServiceInterface
{
    public function createShippingRule(array $data): ShippingRule;

    public function updateShippingRule(int $id, array $data): ShippingRule;

    public function allShippingRules(): LengthAwarePaginator;

    public function getShippingRule(int $id): ShippingRule;

    public function deleteShippingRule(int $id): bool;

    public function saveShippingMethod(User $user, int $shippingRuleId, int $zoneId): array;
}
