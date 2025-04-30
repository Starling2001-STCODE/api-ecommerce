<?php
use App\User\Adapters\Controllers\UserVerificationController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/send-phone-verification', [UserVerificationController::class, 'sendPhoneVerification']);
    Route::post('/verify-phone-code', [UserVerificationController::class, 'verifyPhoneCode']);
    Route::post('/send-email-verification', [UserVerificationController::class, 'sendEmailVerification']);
});

Route::get('/verify-email/{id}/{hash}', [UserVerificationController::class, 'verifyEmail'])
    ->middleware(['signed'])
    ->name('verification.verify');
