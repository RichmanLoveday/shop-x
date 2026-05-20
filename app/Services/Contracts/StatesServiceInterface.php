<?php

namespace App\Services\Contracts;

use App\Models\State;
use Illuminate\Pagination\LengthAwarePaginator;

interface StatesServiceInterface
{
    public function getStates(): LengthAwarePaginator;

    public function getState(int $id): State;

    public function createState(array $data): State;

    public function updateState(array $data, int $id): State;

    public function destroy(int $id): bool;
}
