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
        Schema::create('shipping_zone_shipping_rule', function (Blueprint $table) {
            $table->id();

            $table->foreignId('shipping_zone_id')->constrained()->cascadeOnDelete();
            $table->foreignId('shipping_rule_id')->constrained()->cascadeOnDelete();

            $table->double('override_charge')->nullable()->comment('If null, use shipping_rules.charge');

            $table->unique([
                'shipping_zone_id',
                'shipping_rule_id',
            ], 'zone_rule_unique');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_zone_shipping_rule');
    }
};
