<?php

namespace App\Repositories\Eloquent;

use App\Models\ShippingZone;
use App\Repositories\Contracts\ShippingZoneRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ShippingZoneRepository implements ShippingZoneRepositoryInterface
{
    public function createOrUpdate(array $data, ?int $id = null): ShippingZone
    {
        return ShippingZone::updateOrCreate(
            ['id' => $id],
            [
                'name' => $data['name'],
                'is_active' => $data['is_active'] ?? true,
            ]
        );
    }

    public function findById(int $id): ShippingZone
    {
        return ShippingZone::with(['cities', 'shippingRules' => function ($q) {
            $q->withPivot('override_charge');
        }])->findOrFail($id);
    }

    public function getAll(): LengthAwarePaginator
    {
        return ShippingZone::with(['cities', 'shippingRules'])
            ->withCount('cities')
            ->latest()
            ->paginate(15);
    }

    public function delete(int $id): bool
    {
        return ShippingZone::findOrFail($id)->delete();
    }

    /**
     * CITY PIVOT SYNC
     */
    public function syncCities(int $zoneId, array $cityIds): void
    {
        $zone = ShippingZone::findOrFail($zoneId);

        // remove duplicates + reindex
        $cityIds = array_values(array_unique($cityIds));

        $zone->cities()->sync($cityIds);
    }

    /**
     * SHIPPING RULE PIVOT SYNC (with optional override)
     *
     * expected format:
     * [
     *   1 => ['override_charge' => 2000],
     *   2 => ['override_charge' => null],
     * ]
     */
    public function syncShippingRules(int $zoneId, array $rules): void
    {
        $zone = ShippingZone::findOrFail($zoneId);

        $zone->shippingRules()->syncWithoutDetaching($rules);
    }

    public function updateZoneRuleCharges(int $zoneId, array $rules): ShippingZone
    {
        return DB::transaction(function () use ($zoneId, $rules) {
            $zone = $this->findById($zoneId);

            $syncData = collect($rules)
                ->mapWithKeys(function ($rule) {
                    return [
                        $rule['id'] => [
                            'override_charge' => $rule['override_charge']
                        ]
                    ];
                })
                ->toArray();

            $zone->shippingRules()->syncWithoutDetaching($syncData);

            return $zone->fresh('shippingRules');
        });
    }
}
