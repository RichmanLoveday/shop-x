<?php

namespace App\Services\Vendor;

use App\Models\Brand;
use App\Repositories\Contracts\Vendor\BrandRepositoryInterface;
use App\Services\Contracts\Vendor\BrandServiceInterface;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Override;

class BrandService extends BaseService implements BrandServiceInterface
{
    public function __construct(
        protected BrandRepositoryInterface $brandRepo
    ) {}

    public function findBrand(string $brandName): Collection
    {
        return $this->brandRepo->findBrand($brandName);
    }

    public function allBrand(): LengthAwarePaginator
    {
        return $this->brandRepo->getAllBrand();
    }
}
