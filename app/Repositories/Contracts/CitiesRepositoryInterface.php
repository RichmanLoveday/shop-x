<?php

namespace App\Repositories\Contracts;

use App\Models\City;
use Illuminate\Pagination\LengthAwarePaginator;

interface CitiesRepositoryInterface
{
    public function create(array $data): City;

    public function update(int $id, array $data): City;

    public function findById(int $id): City;

    public function getAll(): LengthAwarePaginator;

    public function delete(int $id): bool;
}
