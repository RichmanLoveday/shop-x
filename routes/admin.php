<?php

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Admin\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Admin\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\PasswordController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\Auth\VerifyEmailController;
use App\Http\Controllers\Admin\kycRequestController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest:admin')
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::controller(AuthenticatedSessionController::class)->group(function () {
            Route::get('login', 'create')->name('login');
            Route::post('login', 'store')->name('login');
        });

        Route::controller(PasswordResetLinkController::class)->group(function () {
            Route::get('forgot-password', 'create')->name('password.request');
            Route::post('forgot-password', 'store')->name('password.email');
        });

        Route::controller(NewPasswordController::class)->group(function () {
            Route::get('reset-password/{token}', 'create')->name('password.reset');
            Route::post('reset-password', 'store')->name('password.store');
        });
    });

Route::middleware('auth:admin')
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::get('verify-email', EmailVerificationPromptController::class)
            ->name('verification.notice');

        Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
            ->middleware(['signed', 'throttle:6,1'])
            ->name('verification.verify');

        Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
            ->middleware('throttle:6,1')
            ->name('verification.send');

        Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
            ->name('password.confirm');

        Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

        Route::put('password', [PasswordController::class, 'update'])->name('password.update');

        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');

        // Profile Controller Routes
        Route::controller(ProfileController::class)->group(function () {
            Route::get('/profile', 'index')->name('profile');
            Route::put('/profile-update', 'updateProfile')->name('profile.update');
            Route::put('/profile/password', 'changePassword')->name('profile.password.update');
        });

        // KYC Request Controller Routes
        Route::controller(kycRequestController::class)->group(function () {
            Route::get('/kyc-request', 'index')->name('kyc.index');
            Route::get('/kyc-request/{id}/show', 'show')->name('kyc.show');
            Route::get('/kyc-request-download/{id}', 'download')->name('kyc.download');
            Route::put('/kyc-request/{id}/update', 'updateStatus')->name('kyc.update');
            Route::get('/kyc-request/pending', 'pending')->name('kyc.pending');
            Route::get('/kyc-request/rejected', 'rejected')->name('kyc.rejected');
            Route::get('/kyc-request/under-review', 'underReview')->name('kyc.under-review');
            Route::get('/kyc-request/approved', 'approved')->name('kyc.approved');
        });

        // Roles Management Routes
        Route::controller(RoleController::class)->group(function () {
            Route::get('/role', 'index')->name('role.index');
            Route::get('/role/create', 'create')->name('role.create');
            Route::post('/role/store', 'store')->name('role.store');
            Route::get('/role/{id}/edit', 'edit')->name('role.edit');
            Route::put('/role/{id}/update', 'update')->name('role.update');
            Route::delete('/role/{id}/delete', 'destroy')->name('role.destroy');
        });
    });

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard.index');
})->middleware(['auth:admin', 'verified'])->name('admin.dashboard');