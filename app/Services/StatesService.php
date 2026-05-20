<?php

namespace App\Services;

use App\Models\State;
use App\Repositories\Contracts\StatesRepositoryInterface;
use App\Services\Contracts\StatesServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class StatesService implements StatesServiceInterface
{
    public function __construct(
        protected StatesRepositoryInterface $stateRepo
    ) {}

    public function createState(array $data): State
    {
        return $this->stateRepo->create([
            'name' => $data['name'],
            'is_active' => $data['is_active'] ?? true,
        ]);
    }

    public function updateState(array $data, int $id): State
    {
        return $this->stateRepo->update($id, [
            'name' => $data['name'],
            'is_active' => $data['is_active'] ?? true,
        ]);
    }

    public function getState(int $id): State
    {
        return $this->stateRepo->findById($id);
    }

    public function getStates(): LengthAwarePaginator
    {
        return $this->stateRepo->getAll();
    }

    public function destroy(int $id): bool
    {
        return $this->stateRepo->delete($id);
    }
}
