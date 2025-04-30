<?php

use App\StripeCheckout\Adapters\Controllers\StripeCheckoutController;
use Illuminate\Support\Facades\Route;

Route::post('/checkout/session/create', [StripeCheckoutController::class, 'createSession']);
