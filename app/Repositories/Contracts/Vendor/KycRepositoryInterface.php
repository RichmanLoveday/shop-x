<?php

namespace App\Repositories\Contracts\Vendor;

use App\Models\Kyc;

interface KycRepositoryInterface
{
    public function create(array $data): Kyc;

    public function getByUserId(int $userId): ?Kyc;

    public function update(Kyc $kyc, array $data): bool;

    public function findForVendor(int $userId, int $kycId): ?Kyc;
}
