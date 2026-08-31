<?php

namespace App\Services\Admin;

use App\Models\Brand;
use App\Models\ShippingMethods;
use App\Repositories\Contracts\Admin\BrandRepositoryInterface;
use App\Repositories\Contracts\Admin\ShippingMethodRepositoryInterface;
use App\Services\Contracts\Admin\BrandServiceInterface;
use App\Services\Contracts\Admin\ShippingMethodInterface;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;

class ShippingMethodService implements ShippingMethodInterface
{
    public function __construct(
        protected ShippingMethodRepositoryInterface $shippingMethodRepo,
    ) {}

    public function addShippingMethod(array $data): ShippingMethods
    {
        return $this->shippingMethodRepo->createShippingMethod([
            'name' => $data['name'],
            'code' => $data['code'],
            'min_days' => $data['min_days'],
            'max_days' => $data['max_days'],
            'is_active' => $data['is_active'] ?? false,
        ]);
    }

    public function updateShippingMethod(int $id, array $data): ShippingMethods
    {
        $payload = [
            'name' => $data['name'],
            'code' => $data['code'],
            'min_days' => $data['min_days'],
            'max_days' => $data['max_days'],
            'is_active' => $data['is_active'] ?? false,
        ];

        return $this->shippingMethodRepo->updateShippingMethod($id, $payload);
    }

    public function allShippingMethods(): array
    {
        $shippingMethods = $this->shippingMethodRepo->getAllShippingMethod();
        $activeMethods = $this->shippingMethodRepo->activeMethods();
        $inactiveMethods = $this->shippingMethodRepo->inactiveMethods();
        $configuredRates = $this->shippingMethodRepo->configuredRates();

        return [
            'shippingMethods' => $shippingMethods,
            'activeMethods' => $activeMethods,
            'inactiveMethods' => $inactiveMethods,
            'configuredRates' => $configuredRates,
        ];
    }

    public function getShippingMethod(int $id): ShippingMethods
    {
        return $this->shippingMethodRepo->getShippingMethod($id);
    }

    public function delete(int $id): bool
    {
        $shippingMethod = $this->getShippingMethod($id);
        return $shippingMethod->delete();
    }
}