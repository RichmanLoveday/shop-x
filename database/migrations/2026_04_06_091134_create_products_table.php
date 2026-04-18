<?php

use App\Enums\ProductStatus;
use App\Enums\ProductType;
use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained('stores');
            $table->foreignId('brand_id')->constrained('brands');
            $table->string('name');
            $table->string('slug');
            $table->double('price')->nullable();
            $table->enum('product_type', array_column(ProductType::cases(), 'value'))->nullable();
            $table->longText('description');
            $table->text('short_description')->nullable();
            $table->double('special_price')->nullable();
            $table->date('special_price_start')->nullable();
            $table->date('special_price_end')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('sku')->nullable();
            $table->enum('manage_stock', ['yes', 'no'])->default('no')->nullable();
            $table->integer('qty')->nullable();
            $table->boolean('stock_status')->nullable();
            $table->integer('viewed')->nullable();
            $table->enum('status', array_column(ProductStatus::cases(), 'value'))->nullable();
            $table->boolean('is_featured')->nullable();
            $table->boolean('is_hot')->nullable();
            $table->boolean('is_new')->nullable();

            $table->softDeletesDatetime();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
