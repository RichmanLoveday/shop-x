<?php

namespace App\Repositories\Eloquent\Vendor;

use App\Models\Category;
use App\Repositories\Contracts\Vendor\CategoryRepositoryInterface;
use App\Repositories\Eloquent\Core\BaseCategoryRepository;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository extends BaseCategoryRepository implements CategoryRepositoryInterface {}
