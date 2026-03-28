<?php

namespace App\Services\Contracts\Admin;

use App\Models\Admin;
use App\Models\Kyc;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

interface KycServiceInterface
{
    public function getAllKyc(): LengthAwarePaginator;

    public function getKycById(int $kycId): Kyc;

    public function updateKycStatus(int $kycId, string $status, ?string $reason = null): Kyc;

    public function getKycByStatus(string $status): LengthAwarePaginator;

    public function downloadDocument(int $kycId): BinaryFileResponse;

    public function sendMail(Kyc $kyc, string $status): void;
}
