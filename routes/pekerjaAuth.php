<?php

namespace App\Http\Controllers\PekerjaAuth;

use App\Http\Controllers\PekerjaAuth\AuthenticatedSessionController;
use App\Http\Controllers\PekerjaAuth\ConfirmablePasswordController;
use App\Http\Controllers\PekerjaAuth\EmailVerificationNotificationController;
use App\Http\Controllers\PekerjaAuth\EmailVerificationPromptController;
use App\Http\Controllers\PekerjaAuth\NewPasswordController;
use App\Http\Controllers\PekerjaAuth\PekerjaPasswordController;
use App\Http\Controllers\PekerjaAuth\PasswordResetLinkController;
use App\Http\Controllers\PekerjaAuth\RegisteredUserController;
use App\Http\Controllers\PekerjaAuth\VerifyEmailController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['guest:pekerja'], 'prefix'=>'pekerja','as'=>'pekerja.'], function() {

    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store'])->name('register');;

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password-pekerja', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password-pekerja', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password-pekerja/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password-pekerja', [NewPasswordController::class, 'store'])
                ->name('password.store');
});

Route::group(['middleware' => ['auth:pekerja'], 'prefix'=>'pekerja','as'=>'pekerja.'], function() {
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

    Route::put('password', [PekerjaPasswordController::class, 'update'])->name('updatePasswordPekerja');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});
