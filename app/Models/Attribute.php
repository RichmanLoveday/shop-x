<?php

namespace App\Models;

use App\Enums\ProductAttributeType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = [
        'name',
        'type',
    ];

    protected $casts = [
        'type' => ProductAttributeType::class,
    ];

    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }

    

    public function scopeWithValuesForProduct(Builder $query, int $productId): void
    {
        $query->with(['values' => function ($valueQuery) use ($productId) {
            $valueQuery
                ->whereIn('id', function ($subquery) use ($productId) {
                    $subquery
                        ->select('attribute_value_id')
                        ->from('product_attribute_values')
                        ->where('product_id', $productId)
                        ->orderBy('id', 'asc');
                })
                ->orderBy('id', 'asc');
        }]);
    }
}
