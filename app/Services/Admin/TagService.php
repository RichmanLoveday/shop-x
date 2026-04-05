<?php

namespace App\Services\Admin;

use App\Models\Tag;
use App\Repositories\Contracts\Admin\ProductRepositoryInterface;
use App\Services\Contracts\Admin\TagServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class TagService implements TagServiceInterface
{
    public function __construct(
        protected ProductRepositoryInterface $productRepo
    ) {}

    public function addNewTag(array $data): Tag
    {
        $payload['name'] = $data['name'];
        $payload['is_active'] = isset($data['status']) ? 1 : 0;
        $payload['slug'] = $this->createSlug($data['name']);

        return $this->productRepo->createTag($payload);
    }

    public function getTag(int $id): Tag
    {
        return $this->productRepo->getTag($id);
    }

    public function allTags(): LengthAwarePaginator
    {
        return $this->productRepo->getAllTags();
    }

    public function updateTag(int $id, array $data): Tag
    {
        $tag = $this->getTag($id);

        $payload['name'] = $data['name'];
        $payload['slug'] = $tag->name !== $data['name'] ? $this->createSlug($data['name']) : $tag->slug;

        return $this->productRepo->updateTag($id, $payload);
    }

    public function delete(int $id): bool
    {
        $tag = $this->getTag($id);

        return $tag->delete();
    }

    private function createSlug(string $tagName): string
    {
        $slug = Str::slug($tagName, '-');
        $originalSlug = $slug;
        $count = 1;

        while ($this->productRepo->checkIfTagSlugExit($slug)) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }
}
