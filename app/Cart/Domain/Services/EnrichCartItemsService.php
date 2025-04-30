<?php

namespace App\Cart\Domain\Services;

use App\Product\Domain\Contracts\ProductRepositoryPort;
use App\CartDetail\Domain\Entities\CartDetail;
use Illuminate\Support\Facades\Log;


class EnrichCartItemsService
{
    private ProductRepositoryPort $productRepository;

    public function __construct(ProductRepositoryPort $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute(array $cartDetails): array
    {
        $enrichedItems = [];

        foreach ($cartDetails as $detail) {
            $productId = $this->getValue($detail, 'product_id');
            $variantId = $this->getValue($detail, 'variant_id');
            $quantity = $this->getValue($detail, 'quantity');
            $priceAtTime = $this->getValue($detail, 'price_at_time');
            $detailId = $this->getValue($detail, 'id');

            $product = $this->productRepository->findById($productId);

            $item = [
                'id' => $detailId,
                'product_id' => $productId,
                'variant_id' => $variantId,
                'quantity' => $quantity,
                'selected' => true,
            ];

            if ($variantId) {
                $variant = collect($product->variants)->firstWhere('id', $variantId);

                $item['name'] = $variant['sku'] ?? $product->name;
                $item['sku'] = $variant['sku'] ?? '';
                $item['price_at_time'] = $variant['price'] ?? $priceAtTime;
                $item['stock_at_time'] = $variant['quantity'] ?? 0;
                $item['image'] = $variant['images'][0]['url']
                    ?? $variant['attribute_value_images'][0]['url']
                    ?? '';
                $item['attributes'] = $variant['attribute_values'] ?? [];

            } else {
                $item['name'] = $product->name;
                $item['sku'] = $product->sku ?? '';
                $item['price_at_time'] = $product->sale_price ?? $priceAtTime;
                $item['stock_at_time'] = $product->inventory->quantity ?? 0;
                $item['image'] = $product->images[0]['url'] ?? '';
                $item['attributes'] = [];
            }

            $enrichedItems[] = $item;
        }

        return $enrichedItems;
    }

    private function getValue($item, string $key)
    {
        return is_array($item) ? $item[$key] ?? null : $item->{$key} ?? null;
    }
}
