<?php

use App\Enums\KycDocumentType;
use App\Enums\KycGender;
use App\Enums\KycStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kycs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('reviewed_by')->constrained('admins');
            $table
                ->enum('status', array_column(KycStatus::cases(), 'value'))
                ->default(KycStatus::PENDING->value);
            $table->text('rejected_reason')->nullable();
            $table->timestamp('verified_at');
            $table->string('full_address');
            $table->enum('gender', array_column(KycGender::cases(), 'value'));
            $table->enum('document_type', array_column(KycDocumentType::cases(), 'value'));
            $table->string('document_scan_copy');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kycs');
    }
};