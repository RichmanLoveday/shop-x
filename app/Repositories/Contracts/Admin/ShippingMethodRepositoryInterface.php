<?php

namespace App\Repositories\Contracts\Admin;

use App\Models\Brand;
use App\Models\ShippingMethods;
use Illuminate\Pagination\LengthAwarePaginator;

interface ShippingMethodRepositoryInterface
{
    public function createShippingMethod(array $data): ShippingMethods;

    public function updateShippingMethod(int $id, array $data): ShippingMethods;

    public function getShippingMethod(int $id): ShippingMethods;

    public function getAllShippingMethod(): LengthAwarePaginator;

    public function activeMethods(): int;

    public function inactiveMethods(): int;

    public function configuredRates(): int;
}