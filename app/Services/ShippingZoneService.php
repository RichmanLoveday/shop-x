<?php

namespace App\Services;

use App\Models\ShippingZone;
use App\Models\User;
use App\Repositories\Contracts\ShippingZoneRepositoryInterface;
use App\Services\Contracts\AddressServiceInterface;
use App\Services\Contracts\ShippingZoneResolverServiceInterface;
use App\Services\Contracts\ShippingZoneServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class ShippingZoneService implements ShippingZoneServiceInterface
{
    public function __construct(
        protected ShippingZoneRepositoryInterface $shippingZoneRepo,
        public AddressServiceInterface $addressService,
        public ShippingZoneResolverServiceInterface $shippingZoneResolverService,
    ) {}

    public function createZone(array $data): ShippingZone
    {
        return DB::transaction(function () use ($data) {
            $zone = $this->shippingZoneRepo->createOrUpdate($data);

            // cities
            if (!empty($data['city_ids'])) {
                $this->shippingZoneRepo->syncCities($zone->id, $data['city_ids']);
            }

            // shipping rules
            if (!empty($data['shipping_rule_ids'])) {
                $rules = [];

                foreach ($data['shipping_rule_ids'] as $ruleId) {
                    $rules[$ruleId] = [
                        'override_charge' => null
                    ];
                }

                $this->shippingZoneRepo->syncShippingRules($zone->id, $rules);
            }

            return $zone;
        });
    }

    public function updateZone(array $data, int $id): ShippingZone
    {
        // dd($data);
        return DB::transaction(function () use ($data, $id) {
            $zone = $this->shippingZoneRepo->createOrUpdate($data, $id);

            if (isset($data['city_ids'])) {
                $this->shippingZoneRepo->syncCities($zone->id, $data['city_ids']);
            }

            if (isset($data['shipping_rule_ids'])) {
                $rules = [];

                foreach ($data['shipping_rule_ids'] as $ruleId) {
                    // $rules[$ruleId] = [
                    //     'override_charge' => null
                    // ];
                    $rules[$ruleId] = [];
                }

                $this->shippingZoneRepo->syncShippingRules($zone->id, $rules);
            }

            return $zone;
        });
    }

    public function getZone(int $id): ShippingZone
    {
        return $this->shippingZoneRepo->findById($id);
    }

    public function getZones(): LengthAwarePaginator
    {
        return $this->shippingZoneRepo->getAll();
    }

    public function deleteZone(int $id): bool
    {
        return $this->shippingZoneRepo->delete($id);
    }

    public function getZoneRules(int $zoneId): array
    {
        $zone = $this->shippingZoneRepo->findById($zoneId);

        return [
            'zone_id' => $zone->id,
            'zone_name' => $zone->name,
            'shipping_rules' => $zone->shippingRules->map(function ($rule) {
                return [
                    'id' => $rule->id,
                    'name' => $rule->name,
                    'base_charge' => $rule->charge,
                    'override_charge' => $rule->pivot?->override_charge,
                    'final_charge' => $rule->pivot?->override_charge ?? $rule->charge,
                ];
            })->values()
        ];
    }

    public function updateZoneRuleCharges(int $id, array $data): array
    {
        $zone = $this->shippingZoneRepo->updateZoneRuleCharges($id, $data);

        return [
            'zone_id' => $zone->id,
            'zone_name' => $zone->name,
            'shipping_rules' => $zone->shippingRules->map(function ($rule) {
                return [
                    'id' => $rule->id,
                    'name' => $rule->name,
                    'base_charge' => $rule->charge,
                    'override_charge' => $rule->pivot?->override_charge,
                    'final_charge' => $rule->pivot?->override_charge ?? $rule->charge,
                ];
            })->values()->toArray()
        ];
    }

    public function getShippingMethodsByCity(User $user): array
    {
        if (!$user) {
            throw new RuntimeException('Please login to add product to cart');
        }

        $address = $this->addressService->getDefaultAddress($user);
        $shippingMethods = [];

        // throw exemption when address not set
        if (!$address) {
            $shippingMethods['shipping'] = null;
            $shippingMethods['shipping_error'] = 'Please set a delivery address';
            return $shippingMethods;
        }

        $resolved = $this->shippingZoneResolverService->resolveByCity($address->city_id);
        $shippingMethods['shipping'] = $resolved;
        $shippingMethods['shipping_error'] = null;

        return $shippingMethods;
    }

    public function getZoneByName(string|int $name): ?Collection
    {
        return $this->shippingZoneRepo->fetchZoneByName($name);
    }
}