<?php

namespace App\Order\Domain\Services;

use App\Order\Domain\Contracts\OrderRepositoryPort;
use App\Product\Domain\Contracts\ProductRepositoryPort;
use App\Order\Domain\Entities\Order;
use Illuminate\Support\Facades\Auth;

class FindOrderByIdService
{
    private OrderRepositoryPort $orderRepository;
    private ProductRepositoryPort $productRepository;

    public function __construct(
        OrderRepositoryPort $orderRepository,
        ProductRepositoryPort $productRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
    }

    public function execute(string $orderId): Order
    {
        $userId = Auth::guard('sanctum')->id();
        $order = $this->orderRepository->findById($orderId);

        if ($order->user_id !== $userId) {
            abort(403, 'No autorizado a ver esta orden.');
        }

        $enrichedItems = [];
        foreach ($order->items as $item) {
            $productId = $item['product_id'] ?? null;
            $variantId = $item['variant_id'] ?? null;
            $quantity = $item['quantity'] ?? 0;
            $priceAtTime = $item['price_at_time'] ?? 0.0;

            $product = $this->productRepository->findById($productId);

            $enrichedItem = [
                'id' => $item['id'] ?? null,
                'product_id' => $productId,
                'variant_id' => $variantId,
                'quantity' => $quantity,
                'price_at_time' => $priceAtTime,
            ];

            if ($variantId) {
                $variant = collect($product->variants)->firstWhere('id', $variantId);

                $enrichedItem['name'] = $variant['sku'] ?? $product->name;
                $enrichedItem['sku'] = $variant['sku'] ?? '';
                $enrichedItem['price_at_time'] = $variant['price'] ?? $priceAtTime;
                $enrichedItem['stock_at_time'] = $variant['quantity'] ?? 0;
                $enrichedItem['image'] = $variant['images'][0]['url']
                    ?? $variant['attribute_value_images'][0]['url']
                    ?? '';
                $enrichedItem['attributes'] = $variant['attribute_values'] ?? [];
            } else {
                $enrichedItem['name'] = $product->name;
                $enrichedItem['sku'] = $product->sku ?? '';
                $enrichedItem['price_at_time'] = $product->sale_price ?? $priceAtTime;
                $enrichedItem['stock_at_time'] = $product->inventory->quantity ?? 0;
                $enrichedItem['image'] = $product->images[0]['url'] ?? '';
                $enrichedItem['attributes'] = [];
            }

            $enrichedItems[] = $enrichedItem;
        }

        $order->items = $enrichedItems;

        return $order;
    }
}
