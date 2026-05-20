<?php

namespace App\Repositories\Contracts;

use App\Models\State;
use Illuminate\Pagination\LengthAwarePaginator;

interface StatesRepositoryInterface
{
    public function create(array $data): State;

    public function update(int $id, array $data): State;

    public function findById(int $id): State;

    public function getAll(): LengthAwarePaginator;

    public function delete(int $id): bool;
}
