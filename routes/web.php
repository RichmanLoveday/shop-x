<?php

use App\Enums\UserRole;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\KycController;
use App\Http\Controllers\Frontend\ProductPageController;
use App\Http\Controllers\Frontend\ProfileController as FrontendProfileController;
use App\Http\Controllers\Frontend\UserDashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('frontend.home.index');
});

// User Grouped Routes
Route::group(['middleware' => ['auth:web', 'verified', 'role:' . UserRole::USER->value]], function () {
    Route::controller(UserDashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
    });

    // Profile Controller Routes
    Route::controller(FrontendProfileController::class)->group(function () {
        Route::get('/profile', 'index')->name('profile.index');
        Route::put('/profile/update', 'update')->name('profile.update');
        Route::put('/profile/change-password', 'changePassword')->name('profile.change-password');
    });
});

/** Product Page Controller */
Route::controller(ProductPageController::class)->group(function () {
    Route::get('/products', 'index');
    Route::get('/products/{slug}', 'show')->name('products.show');
    Route::get('/product/{type}/{id}', 'getProduct')->name('products.getProduct');
});

/** Cart Controller */
Route::controller(CartController::class)->group(function () {
    Route::get('/cart', 'index')->name('cart.index');
    Route::post('/cart/add', 'addToCart')->name('cart.add');
    Route::put('/cart/update', 'updateCart')->name('cart.update');
    Route::delete('/cart/{id}/remove', 'removeCartItem')->name('cart.remove');
    Route::delete('/cart/bulk-delete', 'bulkDeleteCartItems')->name('cart.bulk-delete');
    Route::post('/cart/apply-coupon', 'applyCoupon')->name('cart.apply-coupon');
    Route::delete('/cart/remove-coupon', 'removeCoupon')->name('cart.remove-coupon');
});

require __DIR__ . '/auth.php';