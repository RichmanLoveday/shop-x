<?php

namespace App\Repositories\Eloquent\Core;

use App\Models\Tag;
use App\Repositories\Contracts\Core\BaseTagRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BaseTagRepository implements BaseTagRepositoryInterface
{
    public function getAllTags(): LengthAwarePaginator
    {
        return Tag::query()
            ->latest()
            ->paginate(20);
    }

    public function findTag(string $name): Collection
    {
        return Tag::query()
            ->where('name', 'like', "%{$name}%")
            ->where('is_active', true)
            ->get();
    }
}
