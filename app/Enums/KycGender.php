<?php

namespace App\Enums;

enum KycGender: string
{
    case MALE = 'male';
    case FEMALE = 'female';

    /**
     * Get human-readable label
     */
    public function label(): string
    {
        return match ($this) {
            self::MALE => 'Male',
            self::FEMALE => 'Female',
        };
    }
    
}
