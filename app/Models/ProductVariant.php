<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $guarded = [];

    public function attributeValues()
    {
        return $this
            ->belongsToMany(AttributeValue::class, 'product_variant_attribute_value')
            ->withPivot('attribute_id');
    }
}
