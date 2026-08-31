<?php

namespace App\Services;

use App\Models\ShippingRate;
use App\Repositories\Contracts\ShippingRateRepositoryInterface;
use App\Services\Contracts\ShippingRateServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Override;

class ShippingRateService implements ShippingRateServiceInterface
{
    public function __construct(
        protected ShippingRateRepositoryInterface $shippingRateRepository,
    ) {}

    public function addShippingRate(array $data): ShippingRate
    {
        return $this->shippingRateRepository->createOrUpdate($data);
    }

    public function getAllShippingRate(): LengthAwarePaginator
    {
        return $this->shippingRateRepository->allShippingRate();
    }

    public function updateShippingRate(array $data, int|string $id): ShippingRate
    {
        $shippingRate = $this->shippingRateRepository->find($id);
        return $this->shippingRateRepository->createOrUpdate($data, $id);
    }

    public function getShippingRate(int|string $id): ?ShippingRate
    {
        return $this->shippingRateRepository->find($id);
    }

    public function delete(string|int $id): bool
    {
        $shippingRate = $this->shippingRateRepository->find($id);
        return $shippingRate->delete();
    }
}