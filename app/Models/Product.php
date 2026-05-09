<?php

namespace App\Models;

use App\Enums\ProductApprovedStatus;
use App\Enums\ProductStatus;
use App\Enums\ProductType;
use Dom\Attr;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use InteractsWithMedia, SoftDeletes;

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
        'stock_status',
        'viewed',
        'thumbnail',
        'status',
        'approved_status',
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
        'approved_status' => ProductApprovedStatus::class,
    ];

    protected $appends = ['effective_price_and_stock'];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('order');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function attributes(): BelongsToMany
    {
        return $this
            ->belongsToMany(Attribute::class, 'product_attribute_values')
            ->withPivot('attribute_value_id');
    }

    public function attributeValues(): BelongsToMany
    {
        return $this
            ->belongsToMany(AttributeValue::class, 'product_attribute_values')
            ->withPivot('attribute_id');
    }

    public function attributeWithValues(): BelongsToMany
    {
        return $this
            ->belongsToMany(Attribute::class, 'product_attribute_values')
            ->distinct()
            ->orderBy('id', 'asc');
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function primaryVariant(): HasOne
    {
        return $this
            ->hasOne(ProductVariant::class)
            ->where('is_default', true)
            ->where('is_active', true);
    }

    public function files(): HasMany
    {
        return $this->hasMany(ProductFile::class);
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function getEffectivePriceAndStockAttribute(): array
    {
        $getPriceData = function ($id = null, $price, $special_price, $in_stock, $qty) {
            return [
                'id' => $id,
                'price' => $special_price > 0 ? $special_price : $price,
                'old_price' => $special_price > 0 ? $price : null,
                'in_stock' => $in_stock,
                'qty' => $qty,
            ];
        };

        // check if product variant exist
        if ($this->variants()->exists()) {
            $variants = $this->variants()->where('stock_status', true)->orderBy('is_default', 'asc')->get();

            foreach ($variants as $variant) {
                // check if manage stock is enabled
                if ($variant->manage_stock) {
                    if ($variant->qty < 1)
                        continue;

                    return $getPriceData(
                        $variant->id,
                        $variant->price,
                        $variant->special_price,
                        $variant->stock_status,
                        $variant->qty,
                    );
                }

                // stock is not managed, treat as unlimited
                return $getPriceData(
                    $variant->id,
                    $variant->price,
                    $variant->special_price,
                    $variant->stock_status,
                    'Unlimited',
                );
            }

            // if variant condition do not match
            return $getPriceData(null, 0, 0, false, null);
        }

        // when no variant exist
        $stockManaged = $this->manage_stock == 'yes';
        $inStock = $this->in_stock && (!$stockManaged || $this->qty > 0);
        $qty = $stockManaged ? ($this->qty > 0 ? $this->qty : 'null') : ($this->in_stock ? 'Unlimited' : null);

        return $getPriceData(null, $this->price, $this->special_price, $inStock, $qty);
    }
}
