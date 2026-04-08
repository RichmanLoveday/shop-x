<?php

namespace App\Enums;

enum ProductType: string
{
    case PHYSICAL = 'physical';
    case DIGITAL = 'digital';

    /**
     * Get human-readable label
     */
    public function label(): string
    {
        return match ($this) {
            self::PHYSICAL => 'physical',
            self::DIGITAL => 'digital',
        };
    }

    
}