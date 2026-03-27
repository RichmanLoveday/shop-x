<?php

namespace App\Models;

use App\Enums\KycDocumentType;
use App\Enums\KycGender;
use App\Enums\KycStatus;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Kyc extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'reviewed_by',
        'status',
        'rejected_reason',
        'verified_at',
        'full_address',
        'full_name',
        'gender',
        'document_type',
        'document_scan_copy',
    ];

    protected $casts = [
        'status' => KycStatus::class,
        'document_type' => KycDocumentType::class,
        'gender' => KycGender::class,
        'verified_at' => 'datetime',
    ];

    public function canBeEditable(): bool
    {
        return $this->status->isEditable();
    }

    public function canNotBeEditable(): bool
    {
        return $this->status->isNotEditable();
    }
}
