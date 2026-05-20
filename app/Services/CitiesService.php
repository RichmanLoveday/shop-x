<?php

namespace App\Services;

use App\Models\City;
use App\Repositories\Contracts\CitiesRepositoryInterface;
use App\Services\Contracts\CitiesServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class CitiesService implements CitiesServiceInterface
{
    public function __construct(
        protected CitiesRepositoryInterface $cityRepo
    ) {}

    public function createCity(array $data): City
    {
        return $this->cityRepo->create([
            'name' => $data['name'],
            'state_id' => $data['state_id'],
            'is_active' => $data['is_active'] ?? true,
        ]);
    }

    public function updateCity(array $data, int $id): City
    {
        return $this->cityRepo->update($id, [
            'name' => $data['name'],
            'state_id' => $data['state_id'],
            'is_active' => $data['is_active'] ?? true,
        ]);
    }

    public function getCity(int $id): City
    {
        return $this->cityRepo->findById($id);
    }

    public function getCities(): LengthAwarePaginator
    {
        return $this->cityRepo->getAll();
    }

    public function destroy(int $id): bool
    {
        return $this->cityRepo->delete($id);
    }
}
