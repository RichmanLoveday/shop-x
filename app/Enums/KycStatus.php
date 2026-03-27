<?php

namespace App\Enums;

enum KycStatus: string
{
    case PENDING = 'pending';
    case UNDER_REVIEW = 'under_review';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';

    /**
     * Get human-readable label
     */
    public function label(): string
    {
        return match ($this) {
            self::APPROVED => 'Pending Reviews',
            self::UNDER_REVIEW => 'Under Review',
            self::APPROVED => 'Approved',
            self::REJECTED => 'Rejected',
        };
    }

    /**
     * Check if kyc is approved
     */
    public function isApproved(): bool
    {
        return $this === self::APPROVED;
    }

    /**
     * Determine if the KYC status is in an editable state.
     *
     * This method checks whether the current KYC (Know Your Customer) status allows for modifications.
     * A status is considered editable if:
     * - REJECTED: Previously rejected and can be resubmitted
     *
     * @return bool True if the status is editable, false otherwise
     */
    public function isEditable(): bool
    {
        return $this === self::REJECTED;
    }

    /**
     * Check if the KYC status is pending
     *
     * Determines whether the current KYC status is in a pending or under review state.
     *
     * @return bool True if the status is pending or under review, false otherwise
     */
    public function isNotEditable()
    {
        return $this == self::PENDING || self::UNDER_REVIEW;
    }
}
