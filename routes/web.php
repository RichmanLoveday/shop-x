<?php

use App\Http\Controllers\Frontend\KycController;
use App\Http\Controllers\Frontend\ProfileController as FrontendProfileController;
use App\Http\Controllers\Frontend\UserDashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('frontend.home.index');
});

// User Grouped Routes
Route::group(['middleware' => ['auth:web', 'verified']], function () {
    Route::controller(UserDashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
    });

    // Profile Controller Routes
    Route::controller(FrontendProfileController::class)->group(function () {
        Route::get('/profile', 'index')->name('profile.index');
        Route::put('/profile/update', 'update')->name('profile.update');
        Route::put('profile/change-password', 'changePassword')->name('profile.change-password');
    });

    // KYC Controller Routes
    Route::controller(KycController::class)->group(function () {
        Route::get('/kyc-verification', 'index')->name('kyc.index');
        Route::post('/kyc-verification', 'store')->name('kyc.store');
    });
});

require __DIR__ . '/auth.php';
