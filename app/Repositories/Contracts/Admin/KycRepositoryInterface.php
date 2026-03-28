<?php

namespace App\Repositories\Contracts\Admin;

use App\Models\Admin;
use App\Models\Kyc;
use Illuminate\Pagination\LengthAwarePaginator;

interface KycRepositoryInterface
{
    public function getAll(): LengthAwarePaginator;

    public function findById(int $kycId): ?kyc;

    public function updateStatus(int $kycId, int $adminId, string $status, ?string $reason): Kyc;

    public function getKycByStatus(string $status): LengthAwarePaginator;
}
