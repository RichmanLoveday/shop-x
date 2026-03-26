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
     * Check if kyc is editable
     */
    public function isEditable(): bool
    {
        return $this === self::PENDING || self::REJECTED;
    }
}
