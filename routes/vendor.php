<?php

use App\Enums\UserRole;
use App\Http\Controllers\Frontend\KycController;
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
});