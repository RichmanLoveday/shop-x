<?php

use App\Enums\UserRole;
use App\Http\Controllers\Admin\TagsController;
use App\Http\Controllers\Frontend\KycController;
use App\Http\Controllers\Vendor\ProductController;
use App\Http\Controllers\Vendor\StoreController;
use App\Http\Controllers\Vendor\VendorDashboardController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'vendor', 'as' => 'vendor.', 'middleware' => ['auth:web', 'verified', 'role:' . UserRole::VENDOR->value]], function () {
    Route::controller(VendorDashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
    });

    Route::resource('/shop-profile', StoreController::class);

    // KYC Controller Routes
    Route::controller(KycController::class)->group(function () {
        Route::get('/kyc-verification', 'index')->name('kyc.index');
        Route::post('/kyc-verification', 'store')->name('kyc.store');
    });

    /* Tag Route */
    Route::get('/tags/search', [TagsController::class, 'search'])->name('tags.search');

    /** Product Routes */
    Route::controller(ProductController::class)->group(function () {
        Route::get('/products', 'index')->name('products.index');
        Route::get('/product/{type}/create', 'create')->name('products.create');
        Route::post('/product/{type}/store', 'store')->name('products.store');
        Route::delete('/product/{type}/{product}/destroy', 'destroyProduct')->name('product.destroy');

        /* Digital Product Routes */
        Route::post('/product/digital/{type}/{product}/file-upload', 'uploadDigitalProduct')->name('product.digital.file-upload');
        Route::get('/product/digital/{product}/edit', 'editDigitalProduct')->name('product.digital.edit');
        Route::get('/product/digital/{product}/{file}/find', 'getDigitalFile')->name('product.digital.find');
        Route::get('/product/digital/{product}/{file}/status', 'checkDigitalFileStatus')->name('product.digital.status');
        Route::delete('/product/digital/{product}/{file}/destroy', 'destroyDigitalProductFile')->name('product.digital.product.file.destroy');

        // Route::get('/product/storename/{name}')->name('products.storename');

        /** Physical product routes */
        Route::post('/product/upload/image/{type}/{productId}', 'uploadImage')->name('products.upload-image');
        Route::delete('/product/images/{id}', 'destroyProductImage')->name('products.images.destroy');
        Route::post('/product/images/{type}/{productId}/reorder', 'reorderProductImages')->name('products.images.reorder');
        Route::get('/product/physical/{id}/edit', 'edit')->name('products.edit');
        Route::post('/product/{type}/{id}', 'update')->name('products.update');

        /* Product Attribute Routes for physical products */
        Route::post('/product/attributes/{product}/store', 'storeAttributes')->name('products.attributes.store');
        Route::delete('/product/attributes/{product}/destroy/{attribute}', 'destroyAttribute')->name('products.attributes.destroy');
        Route::delete('/product/attributes/{product}/{attributeId}/value/destroy/{attributeValue}', 'destroyAttributeValue')->name('products.attributes.value.destroy');
        Route::post('/product/{product}/variant/update', 'updateProductVariant')->name('products.variant');
    });
});
