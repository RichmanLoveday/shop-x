<?php

namespace App\Services\Contracts;

use App\Models\ShippingZone;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ShippingZoneServiceInterface
{
    public function createZone(array $data): ShippingZone;

    public function updateZone(array $data, int $id): ShippingZone;

    public function getZone(int $id): ShippingZone;

    public function getZones(): LengthAwarePaginator;

    public function deleteZone(int $id): bool;

    public function getZoneRules(int $zoneId): array;

    public function updateZoneRuleCharges(int $id, array $data): array;

    public function getShippingMethodsByCity(User $user): array;

    public function getZoneByName(string|int $name): ?Collection;
}