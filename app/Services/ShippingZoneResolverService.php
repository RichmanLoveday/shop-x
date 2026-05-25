<?php

namespace App\Services;

use App\Repositories\Contracts\ShippingRuleRepositoryInterface;
use App\Repositories\Contracts\ShippingZoneRepositoryInterface;
use App\Services\Contracts\ShippingZoneResolverServiceInterface;
use Override;

class ShippingZoneResolverService implements ShippingZoneResolverServiceInterface
{
    public function __construct(
        public ShippingZoneRepositoryInterface $shippingZoneRepo,
        public ShippingRuleRepositoryInterface $shippingRuleRepo,
    ) {}

    public function resolveByCity(int $cityId): array
    {
        // get zone city
        $zone = $this->shippingZoneRepo->fetchZoneByCityId($cityId);

        // check if zone does not exist for this city, fallback
        if (!$zone) {
            // dd('reached here');
            // check if fallback exist
            $fallbackZone = $this->shippingRuleRepo->fetchFallbackRule();

            if (!$fallbackZone) {
                return [
                    'zone' => null,
                    'city_id' => $cityId,
                    'shipping_rules' => null,
                ];
            }

            return [
                'zone' => null,
                'city_id' => $cityId,
                'shipping_rules' => [
                    [
                        'id' => $fallbackZone?->id,
                        'name' => $fallbackZone?->name,
                        'type' => $fallbackZone->type->label(),
                        'minimum_amount' => $fallbackZone->minimum_amount,
                        'base_charge' => $fallbackZone?->charge,
                        'override_charge' => null,
                        'final_charge' => $fallbackZone?->charge,
                        'is_fallback' => true,
                    ]
                ]
            ];
        }

        return [
            'zone' => [
                'id' => $zone->id,
                'name' => $zone->name,
            ],
            'city_id' => $cityId,
            'shipping_rules' => $zone->shippingRules->map(function ($rule) {
                return [
                    'id' => $rule->id,
                    'name' => $rule->name,
                    'type' => $rule->type->label(),
                    'minimum_amount' => $rule->minimum_amount,
                    'base_charge' => $rule->charge,
                    'override_charge' => $rule->pivot?->override_charge,
                    'final_charge' => $rule->pivot?->override_charge ?? $rule->charge,
                    'is_fallback' => (bool) $rule->is_fallback,
                ];
            })->values()
        ];
    }

    public function calculatedEstimatedDeliveryCost(int $cityId): array
    {
        $resolvedCity = $this->resolveByCity($cityId);
        $rules = $resolvedCity['shipping_rules'] ?? [];

        // check if rules are empty
        if (empty($rules)) {
            return [
                'zone_name' => null,
                'cost' => 0,
                'rule_id' => null,
                'status' => false,
                'message' => 'No shipping rules found'
            ];
        }

        // choose the cheapest among them
        $bestRule = collect($rules)
            ->sortBy('final_charge')
            ->first();

        return [
            'zone_name' => $resolvedCity['zone']['name'],
            'cost' => $bestRule['final_charge'],
            'rule_id' => $bestRule['id'],
            'status' => true,
            'rule_name' => $bestRule['name'],
        ];
    }
}
