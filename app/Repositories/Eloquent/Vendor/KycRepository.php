<?php

namespace App\Repositories\Eloquent\Vendor;

use App\Models\Kyc;
use App\Repositories\Contracts\Vendor\KycRepositoryInterface;

class KycRepository implements KycRepositoryInterface
{
    public function create(array $data): Kyc
    {
        return Kyc::create($data);
    }

    public function getByUserId(int $userId): ?Kyc
    {
        return Kyc::where('user_id', $userId)
            ->latest()
            ->first();
    }

    public function findForVendor(int $userId, int $kycId): ?Kyc
    {
        return Kyc::where('user_id', $userId)
            ->where('id', $kycId)
            ->first();
    }

    public function update(Kyc $kyc, array $data): bool
    {
        return $kyc->update($data);
    }
}
