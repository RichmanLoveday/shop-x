<?php

namespace App\Services\Contracts;

use App\Models\ShippingZone;
use Illuminate\Pagination\LengthAwarePaginator;

interface ShippingZoneServiceInterface
{
    public function createZone(array $data): ShippingZone;

    public function updateZone(array $data, int $id): ShippingZone;

    public function getZone(int $id): ShippingZone;

    public function getZones(): LengthAwarePaginator;

    public function deleteZone(int $id): bool;

    public function getZoneRules(int $zoneId): array;

    public function updateZoneRuleCharges(int $id, array $data): array;
}