<?php

namespace App\Services\Contracts\Admin;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface TagServiceInterface
{
    public function addNewTag(array $data): Tag;

    public function allTags(): LengthAwarePaginator;

    public function getTag(int $id): Tag;

    public function updateTag(int $id, array $data): Tag;

    public function delete(int $id): bool;
}
