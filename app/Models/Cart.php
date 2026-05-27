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

    // public function getVariantOrProductAndStockAttribute(): array
    // {
    //     $variantId = $this->product_variant_id;
    //     $getPriceData = function ($id = null,
    //             $price = 0,
    //             $special_price = 0,
    //             $in_stock = false,
    //             $qty = null) {
    //         return [
    //             'id' => $id,
    //             'price' => $special_price > 0 ? $special_price : $price,
    //             'old_price' => $special_price > 0 ? $price : null,
    //             'in_stock' => $in_stock,
    //             'qty' => $qty,
    //         ];
    //     };

    //     if ($variantId) {
    //         // $variant = $this->variant()->where('id', $variantId)->first();
    //         $variant = $this->variant;
    //         // dd($variant->toArray());

    //         if (!$variant) {
    //             return $getPriceData(null, 0, 0, false, null);
    //         }

    //         // check if manage stock is enabled
    //         if ($variant->manage_stock && $variant->stock_status) {
    //             if ($variant->qty < 1) {
    //                 return $getPriceData(
    //                     $variant->id,
    //                     $variant->price,
    //                     $variant->special_price,
    //                     false,
    //                     null,
    //                 );
    //             }

    //             return $getPriceData(
    //                 $variant->id,
    //                 $variant->price,
    //                 $variant->special_price,
    //                 true,
    //                 $variant->qty,
    //             );
    //         }

    //         $qty = $variant->manage_stock ? ($variant->qty > 0 ? $variant->qty : 'null') : ($variant->stock_status ? 'Unlimited' : null);
    //         $inStock = $variant->stock_status && (!$variant->manage_stock || $variant->qty > 0);

    //         return $getPriceData($variant->id, $variant->price, $variant->special_price, $inStock, $qty);
    //     }

    //     // when no variant exist
    //     // $product = $this->product()->first();

    //     $product = $this->product;

    //     if (!$product) {
    //         return $getPriceData();
    //     }

    //     $stockManaged = $this->product->manage_stock == 'yes';
    //     $inStock = $this->product->stock_status && (!$stockManaged || $this->product->qty > 0);
    //     $qty = $stockManaged ? ($this->product->qty > 0 ? $this->product->qty : 'null') : ($this->product->in_stock ? 'Unlimited' : null);

    //     return $getPriceData($this->product->id, $this->product->price, $this->product->special_price, $inStock, $qty);
    // }

    public function getVariantOrProductAndStockAttribute(): array
    {
        $getPriceData = function (
            $id = null,
            $price = 0,
            $specialPrice = 0,
            $inStock = false,
            $qty = null,
            $isActive = false,
        ) {
            return [
                'id' => $id,
                'price' => $specialPrice > 0 ? $specialPrice : $price,
                'old_price' => $specialPrice > 0 ? $price : null,
                'in_stock' => $inStock,
                'qty' => $qty,
                'is_active' => $isActive,
            ];
        };

        /** Shared stock formatter for variant/product */
        $formatStockData = function ($item, bool $manageStock) use ($getPriceData) {
            $inStock = $item->stock_status &&
                (!$manageStock || $item->qty > 0);

            $qty = $manageStock
                ? ($item->qty > 0 ? $item->qty : null)
                : ($item->stock_status ? 'Unlimited' : null);

            $subTotal = $inStock ? ($item->special_price > 0 ? $item->special_price : $item->price) * $this->qty : 0;

            return $getPriceData(
                $item->id,
                $item->price,
                $item->special_price,
                $inStock,
                $qty,
                $item->is_active,
            );
        };

        /** Variant exists in cart */
        if ($this->product_variant_id) {
            $variant = $this->variant;

            if (!$variant) {
                return $getPriceData();
            }

            return $formatStockData(
                $variant,
                (bool) $variant->manage_stock
            );
        }

        /** No variant → fallback to product */
        $product = $this->product;
        // dd($product->toArray());
        if (!$product) {
            return $getPriceData();
        }

        // dd($product->toArray());
        // dd($formatStockData(
        //     $product,
        //     $product->manage_stock === 'yes'
        // ));
        return $formatStockData(
            $product,
            $product->manage_stock === 'yes'
        );
    }
}
