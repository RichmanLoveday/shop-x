<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shipping_rates', function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId('shipping_method_id')
                ->constrained('shipping_methods')
                ->restrictOnDelete();

            $table
                ->foreignId('origin_zone_id')
                ->constrained('shipping_zones')
                ->restrictOnDelete();

            $table
                ->foreignId('destination_zone_id')
                ->constrained('shipping_zones')
                ->restrictOnDelete();

            $table->decimal('min_order_amount', 12, 2)->default(0);
            $table->decimal('max_order_amount', 12, 2)->nullable();
            $table->decimal('charge', 12, 2);
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index(
                [
                    'shipping_method_id',
                    'origin_zone_id',
                    'destination_zone_id',
                ],
                'shipping_rates_route_index'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_rates');
    }
};