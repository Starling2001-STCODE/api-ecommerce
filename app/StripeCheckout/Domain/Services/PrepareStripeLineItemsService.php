<?php

namespace App\StripeCheckout\Domain\Services;
use Illuminate\Support\Facades\Log;

class PrepareStripeLineItemsService
{
    public function execute(array $cartItems): array
    {
        $lineItems = [];
        $baseUrl = config('app.stripe_url_image');

        foreach ($cartItems as $item) {
            if (empty($item['name']) || empty($item['price_at_time'])) {
                continue;
            }

            $imagePath = $item['image'] ?? null;
            $imageUrl = null;

            if ($imagePath && str_starts_with($imagePath, '/')) {
                $imageUrl = rtrim($baseUrl, '/') . $imagePath;
            } elseif ($imagePath && filter_var($imagePath, FILTER_VALIDATE_URL)) {
                $imageUrl = $imagePath;
            }

            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $item['name'],
                        'images' => $imageUrl ? [$imageUrl] : [],
                    ],
                    'unit_amount' => intval($item['price_at_time'] * 100),
                ],
                'quantity' => intval($item['quantity'] ?? 1),
            ];
        }

        return $lineItems;
    }

}
