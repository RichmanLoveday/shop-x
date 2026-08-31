<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class ShippingRate extends Model
{
    protected $fillable = [
        'store_id',
        'shipping_method_id',
        'origin_zone_id',
        'destination_zone_id',
        'min_order_amount',
        'max_order_amount',
        'charge',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'min_order_amount' => 'decimal:2',
        'max_order_amount' => 'decimal:2',
        'charge' => 'decimal:2',
    ];

    public function shippingMethod(): BelongsTo
    {
        return $this->belongsTo(ShippingMethods::class);
    }

    public function originZone(): BelongsTo
    {
        return $this->belongsTo(ShippingZone::class, 'origin_zone_id');
    }

    public function destinationZone(): BelongsTo
    {
        return $this->belongsTo(ShippingZone::class, 'destination_zone_id');
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
}
