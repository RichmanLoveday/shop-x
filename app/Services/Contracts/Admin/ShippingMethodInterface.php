<?php
namespace App\Services\Contracts\Admin;

use App\Models\ShippingMethods;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ShippingMethodInterface
{
    public function addShippingMethod(array $data): ShippingMethods;

    public function updateShippingMethod(int $id, array $data): ShippingMethods;

    public function allShippingMethods(): array;

    public function getShippingMethod(int $id): ShippingMethods;

    public function delete(int $id): bool;
}
