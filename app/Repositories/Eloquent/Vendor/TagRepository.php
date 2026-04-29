<?php

namespace App\Repositories\Eloquent\Vendor;

use App\Models\Tag;
use App\Repositories\Contracts\Vendor\TagRepositoryInterface;
use App\Repositories\Eloquent\Core\BaseTagRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TagRepository extends BaseTagRepository implements TagRepositoryInterface {}
