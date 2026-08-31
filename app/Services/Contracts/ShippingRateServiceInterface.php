<?php
namespace App\Services\Contracts;

use App\Models\ShippingRate;
use Illuminate\Pagination\LengthAwarePaginator;

interface ShippingRateServiceInterface
{
    public function addShippingRate(array $data): ShippingRate;

    public function getShippingRate(int|string $id): ?ShippingRate;

    public function updateShippingRate(array $data, int|string $id): ShippingRate;

    public function getAllShippingRate(): LengthAwarePaginator;

    public function delete(string|int $id): bool;
}