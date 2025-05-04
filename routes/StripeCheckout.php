<?php

use App\StripeCheckout\Adapters\Controllers\StripeCheckoutController;
use App\StripeCheckout\Adapters\Controllers\StripeWebhookController;
use Illuminate\Support\Facades\Route;

Route::post('/checkout/session/create', [StripeCheckoutController::class, 'createSession']);
Route::post('/webhooks/stripe', StripeWebhookController::class);

