<?php

namespace App\Enums;

enum UserRole: string
{
    case USER = 'user';
    case VENDOR = 'vendor';

    public function label(): string
    {
        return match ($this) {
            self::USER => 'user',
            self::VENDOR => 'vendor',
        };
    }
}
