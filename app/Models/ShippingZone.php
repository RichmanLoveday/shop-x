<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingZone extends Model
{
    protected $guarded = [];

    public function cities()
    {
        return $this->belongsToMany(City::class, 'shipping_zone_cities');
    }

    public function shippingRules()
    {
        return $this
            ->belongsToMany(ShippingRule::class, 'shipping_zone_shipping_rule')
            ->withPivot('override_charge');
    }

    public function zones()
    {
        return $this->belongsToMany(ShippingZone::class, 'shipping_zone_shipping_rule');
    }
}
