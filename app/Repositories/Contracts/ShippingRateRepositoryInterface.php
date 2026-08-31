<?php

namespace App\Repositories\Contracts;

use App\Models\ShippingRate;
use Illuminate\Pagination\LengthAwarePaginator;

interface ShippingRateRepositoryInterface
{
    public function createOrUpdate(array $data, ?int $id = null): ShippingRate;

    public function find(int|string $id): ?ShippingRate;

    public function allShippingRate(): LengthAwarePaginator;
}