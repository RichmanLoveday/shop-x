<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $guarded = [];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function zones()
    {
        return $this->belongsToMany(ShippingZone::class, 'shipping_zone_city');
    }
}
