<?php

namespace App\Repositories\Eloquent\Admin;

use App\Enums\KycStatus;
use App\Models\Admin;
use App\Models\Kyc;
use App\Repositories\Contracts\Admin\KycRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Exception;

class KycRepository implements KycRepositoryInterface
{
    public function getAll(): LengthAwarePaginator
    {
        return Kyc::with(['vendor', 'reviewer'])
            ->latest()
            ->paginate(15);
    }

    public function findById(int $kycId): ?Kyc
    {
        return Kyc::with(['vendor', 'reviewer'])->findOrFail($kycId);
    }

    public function updateStatus(int $kycId, int $adminId, string $status, ?string $reason): Kyc
    {
        $kyc = $this->findById($kycId);

        if (!$kyc) {
            throw new Exception('KYC record not found');
        }

        $kyc->update([
            'reviewed_by' => $adminId,
            'status' => $status,
            'rejected_reason' => $reason ?? Null,
            'verified_at' => now(),
        ]);

        // return a fresh database query of current kyc data
        return $kyc->fresh([
            'vendor',
            'reviewer',
        ]);
    }

    public function getKycByStatus(string $status): LengthAwarePaginator
    {
        return Kyc::where('status', $status)
            ->with(['vendor', 'reviewer'])
            ->latest()
            ->paginate(15);
    }
}
