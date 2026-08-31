<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingMethods extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function shippingRates()
    {
        return $this->hasMany(ShippingRate::class,
            'shipping_method_id');
    }
}