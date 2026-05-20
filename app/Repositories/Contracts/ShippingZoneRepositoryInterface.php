<?php

namespace App\Repositories\Contracts;

use App\Models\ShippingZone;
use Illuminate\Pagination\LengthAwarePaginator;

interface ShippingZoneRepositoryInterface
{
    /**
     * Create or update shipping zone
     */
    public function createOrUpdate(array $data, ?int $id = null): ShippingZone;

    /**
     * Find shipping zone by ID
     */
    public function findById(int $id): ShippingZone;

    /**
     * Get all shipping zones (paginated)
     */
    public function getAll(): LengthAwarePaginator;

    /**
     * Delete shipping zone
     */
    public function delete(int $id): bool;

    /**
     * Attach cities to zone (sync pivot)
     */
    public function syncCities(int $zoneId, array $cityIds): void;

    /**
     * Attach shipping rules to zone (sync pivot with optional override)
     */
    public function syncShippingRules(int $zoneId, array $rules): void;

    public function updateZoneRuleCharges(int $zoneId, array $rules): ShippingZone;
}
