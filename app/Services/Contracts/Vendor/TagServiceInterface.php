<?php

namespace App\Services\Contracts\Vendor;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface TagServiceInterface
{
    public function findTag(string $tagName): Collection;

    public function allTags(): LengthAwarePaginator;
}
