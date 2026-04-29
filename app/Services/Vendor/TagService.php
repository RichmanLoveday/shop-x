<?php

namespace App\Services\Vendor;

use App\Repositories\Contracts\Vendor\TagRepositoryInterface;
use App\Services\Contracts\Vendor\TagServiceInterface;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TagService extends BaseService implements TagServiceInterface
{
    public function __construct(
        protected TagRepositoryInterface $tagRepo
    ) {}

    public function findTag(string $tagName): Collection
    {
        return $this->tagRepo->findTag($tagName);
    }

    public function allTags(): LengthAwarePaginator
    {
        return $this->tagRepo->getAllTags();
    }
}
