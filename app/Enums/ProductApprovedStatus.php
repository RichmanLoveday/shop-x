<?php

namespace App\Enums;

enum ProductApprovedStatus: string
{
    case APPROVED = 'approved';
    case PENDING = 'pending';
    case REJECTED = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::APPROVED => 'Approved',
            self::PENDING => 'Pending',
            self::REJECTED => 'Rejected',
            // self::PENDING => 'Pending',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::APPROVED => 'bg-success-lt',
            self::REJECTED => 'bg-danger-lt',
            self::PENDING => 'bg-warning-lt',
        };
    }
}
