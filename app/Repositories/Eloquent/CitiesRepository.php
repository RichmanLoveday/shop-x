<?php

namespace App\Repositories\Eloquent;

use App\Models\City;
use App\Repositories\Contracts\CitiesRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class CitiesRepository implements CitiesRepositoryInterface
{
    public function create(array $data): City
    {
        return City::create($data);
    }

    public function update(int $id, array $data): City
    {
        $city = $this->findById($id);
        $city->update($data);

        return $city->fresh();
    }

    public function findById(int $id): City
    {
        return City::findOrFail($id);
    }

    public function getAll(): LengthAwarePaginator
    {
        return City::query()
            ->with('state')
            ->latest()
            ->paginate(1000);
    }

    public function delete(int $id): bool
    {
        return City::findOrFail($id)->delete();
    }
}
