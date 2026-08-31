<?php

namespace App\Repositories\Eloquent\Admin;

use App\Models\ShippingMethods;
use App\Repositories\Contracts\Admin\ShippingMethodRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ShippingMethodRepository implements ShippingMethodRepositoryInterface
{
    public function createShippingMethod(array $data): ShippingMethods
    {
        return ShippingMethods::create($data);
    }

    public function updateShippingMethod(int $id, array $data): ShippingMethods
    {
        $shippingMethod = $this->getShippingMethod($id);

        $shippingMethod->update($data);

        return $shippingMethod->fresh();
    }

    public function getShippingMethod(int $id): ShippingMethods
    {
        return ShippingMethods::query()
            ->findOrFail($id);
    }

    public function getAllShippingMethod(): LengthAwarePaginator
    {
        return ShippingMethods::query()
            ->withCount(['shippingRates'])
            ->latest()
            ->paginate(25);
    }

    public function activeMethods(): int
    {
        return ShippingMethods::query()
            ->where('is_active', true)
            ->count();
    }

    public function inactiveMethods(): int
    {
        return ShippingMethods::query()
            ->where('is_active', false)
            ->count();
    }

    public function configuredRates(): int
    {
        return ShippingMethods::query()
            ->whereHas('shippingRates')
            ->count();
    }

}