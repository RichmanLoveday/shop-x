<?php

namespace App\Repositories\Contracts\Admin;

use App\Models\Tag;
use App\Repositories\Contracts\Core\BaseTagRepositoryInterface;
use Dom\Attr;

interface TagRepositoryInterface extends BaseTagRepositoryInterface
{
    public function createTag(array $data): Tag;

    public function checkIfTagSlugExit(string $slug): bool;

    public function getTag(int $id): Tag;

    public function updateTag(int $id, array $data): Tag;
}
