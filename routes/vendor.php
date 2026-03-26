<?php

use App\Http\Controllers\Vendor\VendorDashboardController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'vendor', 'as' => 'vendor.', 'middleware' => ['auth:web', 'verified']], function () {
    Route::controller(VendorDashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
    });
});
