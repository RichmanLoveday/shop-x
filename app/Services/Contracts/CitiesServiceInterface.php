<?php

namespace App\Services\Contracts;

use App\Models\City;
use Illuminate\Pagination\LengthAwarePaginator;

interface CitiesServiceInterface
{
    public function createCity(array $data): City;

    public function updateCity(array $data, int $id): City;

    public function getCity(int $id): City;

    public function getCities(): LengthAwarePaginator;

    public function destroy(int $id): bool;
}
