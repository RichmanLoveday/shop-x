<?php

namespace App\Models;

use App\Enums\ShippingRulesType;
use Illuminate\Database\Eloquent\Model;

class ShippingRule extends Model
{
    protected $guarded = [];

    protected $casts = [
        'type' => ShippingRulesType::class,
        'is_active' => 'boolean',
    ];
}
