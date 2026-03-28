<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Store extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'logo',
        'banner',
        'name',
        'email',
        'phone',
        'address',
        'short_desc',
        'long_desc',
    ];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
