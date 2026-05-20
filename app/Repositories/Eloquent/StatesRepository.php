<?php

namespace App\Repositories\Eloquent;

use App\Models\State;
use App\Repositories\Contracts\StatesRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class StatesRepository implements StatesRepositoryInterface
{
    public function create(array $data): State
    {
        return State::create($data);
    }

    public function update(int $id, array $data): State
    {
        $state = $this->findById($id);
        $state->update($data);

        return $state->fresh();
    }

    public function findById(int $id): State
    {
        return State::with(['cities' => function ($q) {
            $q->where('is_active', true);
        }])
            ->findOrFail($id);
    }

    public function getAll(): LengthAwarePaginator
    {
        return State::query()
            ->withCount('cities')
            ->latest()
            ->paginate(100);
    }

    public function delete(int $id): bool
    {
        return State::findOrFail($id)->delete();
    }
}
