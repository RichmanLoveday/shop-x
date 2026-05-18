<?php

namespace App\Enums;

enum ShippingRulesType: string
{
    case MIN_ORDER_AMOUNT = 'minimum_order_amount';
    case FLAT_CHARGE = 'flat_charge';

    /**
     * Get human-readable label
     */
    public function label(): string
    {
        return match ($this) {
            self::MIN_ORDER_AMOUNT => 'Minimum Order Amount',
            self::FLAT_CHARGE => 'Flat Charge',
        };
    }
}
