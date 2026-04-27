<?php

namespace App\Repositories\Eloquent\Admin;

use App\Models\Tag;
use App\Repositories\Contracts\Admin\TagRepositoryInterface;
use App\Repositories\Eloquent\Core\BaseTagRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TagRepository extends BaseTagRepository implements TagRepositoryInterface
{
    public function createTag(array $data): Tag
    {
        return Tag::create($data);
    }

    public function checkIfTagSlugExit(string $slug): bool
    {
        return Tag::query()
            ->where('slug', $slug)
            ->exists();
    }

    public function getTag(int $id): Tag
    {
        return Tag::findOrFail($id);
    }

    public function updateTag(int $id, array $data): Tag
    {
        $tag = $this->getTag($id);

        $tag->update($data);

        return $tag->fresh();
    }
}