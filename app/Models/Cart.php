<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $guarded = [];

    protected $appends = ['variant_or_product_and_stock'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    public function getVariantOrProductAndStockAttribute(): array
    {
        $variantId = $this->product_variant_id;
        $getPriceData = function ($id = null, $price, $special_price, $in_stock, $qty) {
            return [
                'id' => $id,
                'price' => $special_price > 0 ? $special_price : $price,
                'old_price' => $special_price > 0 ? $price : null,
                'in_stock' => $in_stock,
                'qty' => $qty,
            ];
        };

        if ($variantId) {
            $variant = $this->variant()->where('id', $variantId)->first();

            if (!$variant) {
                return $getPriceData(null, 0, 0, false, null);
            }

            // check if manage stock is enabled
            if ($variant->manage_stock && $variant->stock_status) {
                if ($variant->qty < 1) {
                    return $getPriceData(
                        $variant->id,
                        $variant->price,
                        $variant->special_price,
                        false,
                        null,
                    );
                }

                return $getPriceData(
                    $variant->id,
                    $variant->price,
                    $variant->special_price,
                    true,
                    $variant->qty,
                );
            }

            $qty = $variant->manage_stock ? ($variant->qty > 0 ? $variant->qty : 'null') : ($variant->stock_status ? 'Unlimited' : null);
            $inStock = $variant->stock_status && (!$variant->manage_stock || $variant->qty > 0);

            return $getPriceData($variant->id, $variant->price, $variant->special_price, $inStock, $qty);
        }

        // when no variant exist
        $product = $this->product()->first();
        $stockManaged = $this->product->manage_stock == 'yes';
        $inStock = $this->product->in_stock && (!$stockManaged || $this->product->qty > 0);
        $qty = $stockManaged ? ($this->product->qty > 0 ? $this->product->qty : 'null') : ($this->product->in_stock ? 'Unlimited' : null);

        return $getPriceData($this->product->id, $this->product->price, $this->product->special_price, $inStock, $qty);
    }
}
