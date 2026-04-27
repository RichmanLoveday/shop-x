<?php

namespace App\Repositories\Contracts\Core;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseTagRepositoryInterface
{
    public function getAllTags(): LengthAwarePaginator;

    public function findTag(string $name): Collection;
}