<?php

namespace App\Enums;

enum ProductStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case DRAFT = 'draft';
    // case PENDING = 'pending';

    /**
     * Get human-readable label
     */
    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Active',
            self::INACTIVE => 'In-active',
            self::DRAFT => 'Draft',
            // self::PENDING => 'Pending',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::ACTIVE => 'bg-success-lt',
            self::INACTIVE => 'bg-danger-lt',
            // self::PENDING => 'bg-warning-lt',
            self::DRAFT => 'bg-warning-lt'
        };
    }
}
