<?php

namespace App\Enums;

enum KycDocumentType: string
{
    case PASSPORT = 'passport';
    case DRIVING_LICENSE = 'driving_license';
    case ID_CARD = 'id_card';

    /**
     * Get human-readable label
     */
    public function label(): string
    {
        return match ($this) {
            self::PASSPORT => 'Passport',
            self::DRIVING_LICENSE => 'Driving License',
            self::ID_CARD => 'ID Card',
        };
    }
}
