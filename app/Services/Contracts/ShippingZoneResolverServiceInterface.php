<?php

namespace App\Services\Contracts;

interface ShippingZoneResolverServiceInterface
{
    public function resolveByCity(int $cityId): array;

    public function calculatedEstimatedDeliveryCost(int $cityId): array;
}
