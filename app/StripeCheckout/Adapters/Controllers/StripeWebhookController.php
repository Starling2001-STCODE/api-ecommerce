<?php

namespace App\StripeCheckout\Adapters\Controllers;

use Illuminate\Http\Request;
use App\StripeCheckout\Domain\Services\HandleStripeWebhookService;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class StripeWebhookController
{
    private HandleStripeWebhookService $handleStripeWebhookService;

    public function __construct(HandleStripeWebhookService $handleStripeWebhookService)
    {
        $this->handleStripeWebhookService = $handleStripeWebhookService;
    }

    public function __invoke(Request $request)
    {
        $payload = $request->getContent();

        try {
            $this->handleStripeWebhookService->execute($payload);

            return response()->json(['status' => 'Webhook received successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Stripe Webhook Error', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Webhook handling failed'], Response::HTTP_BAD_REQUEST);
        }
    }
}
