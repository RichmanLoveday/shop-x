<?php

namespace App\Models;

use App\Enums\ProductStatus;
use App\Enums\ProductType;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'store_id',
        'brand_id',
        'name',
        'slug',
        'price',
        'product_type',
        'description',
        'short_description',
        'special_price',
        'special_price_start',
        'special_price_end',
        'sku',
        'manage_stock',
        'qty',
        'in_stock',
        'viewed',
        'thumbnail',
        'status',
        'is_featured',
        'is_hot',
        'is_new',
    ];

    protected $casts = [
        'price' => 'float',
        'special_price' => 'float',
        'special_price_start' => 'date',
        'special_price_end' => 'date',
        'qty' => 'integer',
        'in_stock' => 'boolean',
        'is_featured' => 'boolean',
        'is_hot' => 'boolean',
        'is_new' => 'boolean',
        'status' => ProductStatus::class,
        'product_type' => ProductType::class,
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
