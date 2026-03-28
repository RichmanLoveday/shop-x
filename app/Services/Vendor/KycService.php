<?php

namespace App\Services\Vendor;

use App\Enums\KycStatus;
use App\Models\Kyc;
use App\Models\User;
use App\Repositories\Contracts\Vendor\KycRepositoryInterface;
use App\Services\Contracts\Vendor\KycServiceInterface;
use App\Services\MailService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class KycService implements KycServiceInterface
{
    public function __construct(
        protected KycRepositoryInterface $kycRepository,
    ) {}

    public function addVendorKyc(array $data): Kyc
    {
        $vendor = Auth::guard('web')->user();

        // check if vendor is authenticated
        if (!$vendor) {
            throw new Exception('Vendor must be authenticated');
        }

        // dd($data);

        // check if kyc already exist
        $existingKyc = $this->getCurrentVendorKyc();
        $document = $data['document_scan_copy'] ?? null;

        // check if vendor already has some pending kyc
        if ($existingKyc && $existingKyc->canNotBeEditable()) {
            throw new Exception('You already have a pending KYC verification');
        }

        // extract inputs needed
        $kycData = [
            'user_id' => $vendor->id,
            'status' => KycStatus::PENDING->value,
            'full_address' => $data['full_address'] ?? null,
            'full_name' => $data['full_name'] ?? null,
            'document_type' => $data['document_type'] ?? null,
            'gender' => $data['gender'] ?? null,
        ];

        return DB::transaction(function () use ($existingKyc, $kycData, $document) {
            // update kyc if it is rejected and can be editable
            if ($existingKyc && $existingKyc->canBeEditable()) {
                // Update existing rejected KYC
                $this->kycRepository->update($existingKyc, $kycData);
                $kyc = $existingKyc;
            } else {
                // Create new KYC
                $kyc = $this->kycRepository->create($kycData);
            }

            // Handle document upload if provided
            if ($document instanceof UploadedFile) {
                $mediaUrl = $this->uploadKycScannedDocument($kyc, $document);

                // Save media url to document scan copy column
                $this->kycRepository->update($kyc, [
                    'document_scan_copy' => $mediaUrl,
                ]);
            }

            // send confirmation email to vendor
            $this->sendMail($kyc, KycStatus::PENDING->value);

            return $kyc->fresh();
        });
    }

    public function getCurrentVendorKyc(): ?Kyc
    {
        $vendor = Auth::guard('web')->user();
        return $this->kycRepository->getByUserId($vendor->id) ?? Null;
    }

    public function uploadKycScannedDocument(Kyc $kyc, $document): string
    {
        if ($kyc->user_id !== Auth::guard('web')->user()->id) {
            throw new Exception('Unauthorized: You can only upload documents to your own KYC.');
        }

        try {
            // remove old document
            $kyc->clearMediaCollection('document_scan_copy');

            // upload new document
            $media = $kyc
                ->addMedia($document)
                ->usingFileName(uniqid() . '.' . $document->getClientOriginalExtension())
                ->toMediaCollection('document_scan_copy');

            return $media->getUrl();
        } catch (\Exception $e) {
            throw new Exception('Failed to upload kyc document');
        }
    }

    public function sendMail(Kyc $kyc, string $status): void
    {
        match ($status) {
            KycStatus::PENDING->value => MailService::sendkycPending($kyc),
        };
    }

    public function hasApprovedKyc(): bool
    {
        throw new \Exception('Not implemented');
    }
}
