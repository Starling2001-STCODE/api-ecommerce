<?php

namespace App\StripeCheckout\Adapters\Controllers;

use Illuminate\Http\Request;
use App\StripeCheckout\Domain\Services\CreateStripeCheckoutSessionService;

class StripeCheckoutController
{
    private CreateStripeCheckoutSessionService $createSessionService;

    public function __construct(CreateStripeCheckoutSessionService $createSessionService)
    {
        $this->createSessionService = $createSessionService;
    }

    public function createSession(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|string',
            'items.*.variant_id' => 'nullable|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price_at_time' => 'required|numeric|min:0',
        ]);

        try {
            $checkoutUrl = $this->createSessionService->execute($validated['items']);

            return response()->json([
                'url' => $checkoutUrl,
            ], 200);
        } catch (\Exception $e) {
            report($e);
            return response()->json([
                'message' => 'Error al crear la sesión de pago',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
