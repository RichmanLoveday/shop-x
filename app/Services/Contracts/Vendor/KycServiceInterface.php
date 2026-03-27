<?php

namespace App\Services\Contracts\Vendor;

use App\Models\Kyc;

interface KycServiceInterface
{
    /**
     * Summit new kyc document for the authenticated user
     */
    public function addVendorKyc(array $data): Kyc;

    /**
     * Upload scanned document for a KYC record
     */
    public function uploadKycScannedDocument(Kyc $kyc, $document): string;

    /**
     * Get current vendor's KYC record
     */
    public function getCurrentVendorKyc(): ?Kyc;

    /**
     * Check if current vendor has approved KYC
     */
    public function hasApprovedKyc(): bool;
}
