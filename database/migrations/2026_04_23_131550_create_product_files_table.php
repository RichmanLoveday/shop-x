<?php

use App\Enums\ProductFilesStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();

            $table->string('filename');
            $table->enum('disk', ['local', 'public', 'wasabi'])->default('local');
            $table->string('path')->nullable();
            $table->string('extension');

            $table->unsignedBigInteger('size')->nullable();

            $table
                ->enum('status', array_column(ProductFilesStatus::cases(), 'value'))
                ->default(ProductFilesStatus::PROCESSING->value);

            $table->timestamp('processed_at')->nullable();

            $table->timestamps();

            $table->index('product_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_files');
    }
};