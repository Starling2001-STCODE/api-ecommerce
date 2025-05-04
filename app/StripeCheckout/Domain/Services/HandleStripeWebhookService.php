<?php

namespace App\StripeCheckout\Domain\Services;

use Illuminate\Support\Facades\Log;

class HandleStripeWebhookService
{
    public function execute(string $payload): void
    {
        $event = json_decode($payload, true);

        Log::info('Stripe Webhook Received:', [
            'event' => $event,
        ]);
    }
}
