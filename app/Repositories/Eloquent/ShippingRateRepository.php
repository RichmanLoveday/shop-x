<?php

namespace App\Repositories\Eloquent;

use App\Models\ShippingRate;
use App\Repositories\Contracts\ShippingRateRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Override;

class ShippingRateRepository implements ShippingRateRepositoryInterface
{
    public function createOrUpdate(array $data, ?int $id = null): ShippingRate
    {
        return ShippingRate::query()
            ->updateOrCreate(['id' => $id], $data);
    }

    public function find(int|string $id): ?ShippingRate
    {
        return ShippingRate::query()
            ->with(['store', 'originZone', 'destinationZone'])
            ->findOrFail($id);
    }

    public function allShippingRate(): LengthAwarePaginator
    {
        return ShippingRate::query()
            ->with(['store', 'shippingMethod', 'originZone', 'destinationZone'])
            ->latest()
            ->paginate(20);
    }
}