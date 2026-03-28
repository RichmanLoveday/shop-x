<?php

namespace App\Services\Admin;

use App\Enums\KycStatus;
use App\Models\Kyc;
use App\Repositories\Contracts\Admin\KycRepositoryInterface;
use App\Services\Contracts\Admin\KycServiceInterface;
use App\Services\MailService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Exception;

class KycService implements KycServiceInterface
{
    public function __construct(
        protected KycRepositoryInterface $kycRepository
    ) {}

    public function getAllKyc(): LengthAwarePaginator
    {
        return $this->kycRepository->getAll();
    }

    public function updateKycStatus(int $kycId, string $status, ?string $reason = null): Kyc
    {
        $kyc = $this->kycRepository->findById($kycId);
        $admin = Auth::guard('admin')->user();

        if (!$kyc) {
            throw new Exception('KYC record not found.');
        }

        // update status of kyc
        $kyc = $this->kycRepository->updateStatus($kycId, $admin->id, $status, $reason);

        if ($kyc) {
            // send relevant emails to vendor
            $this->sendMail($kyc, $status);
        }

        return $kyc;
    }

    public function getKycById(int $kycId): Kyc
    {
        $kyc = $this->kycRepository->findById($kycId);

        if (!$kyc) {
            throw new Exception('KYC record not found.');
        }

        return $kyc;
    }

    public function getKycByStatus(string $status): LengthAwarePaginator
    {
        return $this->kycRepository->getKycByStatus($status);
    }

    public function downloadDocument(int $kycId): BinaryFileResponse
    {
        $kyc = $this->kycRepository->findById($kycId);

        if (!$kyc) {
            throw new Exception('KYC record not found.');
        }

        // check if scanned document is existing and not empty
        if (!$kyc->document_scan_copy && $kyc->getMedia('document_scan_copy')->isEmpty()) {
            throw new Exception('No document available for download.');
        }

        // check if document is found in media lib
        $media = $kyc->getFirstMedia('document_scan_copy');

        if (!$media) {
            throw new Exception('Document not found in media library.');
        }

        return response()->download(
            $media->getPath(),
            $media->file_name ?? 'kyc-document.pdf',
            [
                'Content-Disposition' => 'attachment; filename="' . $media->file_name . '"',
            ]
        );
    }

    public function sendMail(Kyc $kyc, string $status): void
    {
        match ($status) {
            KycStatus::APPROVED->value => MailService::sendKycApproveMail($kyc),
            KycStatus::REJECTED->value => MailService::sendKycRejected($kyc),
            default => null
        };
    }
}
