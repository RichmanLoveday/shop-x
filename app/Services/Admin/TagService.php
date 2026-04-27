<?php

namespace App\Services\Admin;

use App\Models\Tag;
use App\Repositories\Contracts\Admin\TagRepositoryInterface;
use App\Services\Contracts\Admin\TagServiceInterface;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class TagService extends BaseService implements TagServiceInterface
{
    public function __construct(
        protected TagRepositoryInterface $tagRepo
    ) {}

    public function addNewTag(array $data): Tag
    {
        $payload['name'] = $data['name'];
        $payload['is_active'] = isset($data['status']) ? 1 : 0;
        $payload['slug'] = $this->generateSlug($data['name'], fn($slug) => $this->tagRepo->checkIfTagSlugExit($slug));

        return $this->tagRepo->createTag($payload);
    }

    public function getTag(int $id): Tag
    {
        return $this->tagRepo->getTag($id);
    }

    public function allTags(): LengthAwarePaginator
    {
        return $this->tagRepo->getAllTags();
    }

    public function updateTag(int $id, array $data): Tag
    {
        $tag = $this->getTag($id);

        $payload['name'] = $data['name'];
        $payload['slug'] = $tag->name !== $data['name'] ? $this->generateSlug($data['name'], fn($slug) => $this->tagRepo->checkIfTagSlugExit($slug)) : $tag->slug;

        return $this->tagRepo->updateTag($id, $payload);
    }

    public function delete(int $id): bool
    {
        $tag = $this->getTag($id);

        return $tag->delete();
    }

    public function findTag(string $tagName): Collection
    {
        return $this->tagRepo->findTag($tagName);
    }
}
