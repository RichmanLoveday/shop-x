<?php

namespace App\Models;

use App\Enums\ProductFilesStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class ProductFile extends Model
{
    protected $guarded = [];

    protected $casts = [
        'status' => ProductFilesStatus::class,
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
