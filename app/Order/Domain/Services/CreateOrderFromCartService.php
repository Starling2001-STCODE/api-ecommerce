<?php

namespace App\Order\Domain\Services;

use App\Order\Domain\Contracts\OrderRepositoryPort;
use App\Order\Domain\Contracts\OrderItemRepositoryPort;
use App\Order\Domain\Entities\Order;
use App\Order\Domain\Entities\OrderItem;
use App\Cart\Domain\Contracts\CartRepositoryPort;
use App\CartDetail\Domain\Services\DeleteSelectedCartItemsService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CreateOrderFromCartService
{
    private OrderRepositoryPort $orderRepository;
    private OrderItemRepositoryPort $orderItemRepository;
    private CartRepositoryPort $cartRepository;
    private DeleteSelectedCartItemsService $deleteSelectedCartItemsService;
    public function __construct(
        OrderRepositoryPort $orderRepository,
        OrderItemRepositoryPort $orderItemRepository,
        CartRepositoryPort $cartRepository,
        DeleteSelectedCartItemsService $deleteSelectedCartItemsService,
    ) {
        $this->orderRepository = $orderRepository;
        $this->orderItemRepository = $orderItemRepository;
        $this->cartRepository = $cartRepository;
        $this->deleteSelectedCartItemsService = $deleteSelectedCartItemsService;
    }

    public function execute(array $validatedCartItems): Order
    {
        return DB::transaction(function () use ($validatedCartItems) {
            $userId = Auth::guard('sanctum')->id();
            $orderId = (string) Str::ulid();
            $total = collect($validatedCartItems)->sum(fn($item) =>
                $item['price_at_time'] * $item['quantity']
            );

            $orderEntity = new Order([
                'id' => $orderId,
                'user_id' => $userId,
                'status' => 'pending_payment',
                'checkout_url' => null,
                'session_id' => null,
                'expires_at' => null,
                'total' => $total,
                'items' => [],
            ]);

            $this->orderRepository->create($orderEntity);

            $orderItems = collect($validatedCartItems)->map(function ($item) use ($orderId) {
                return new OrderItem([
                    'id' => (string) Str::ulid(),
                    'order_id' => $orderId,
                    'product_id' => $item['product_id'],
                    'variant_id' => $item['variant_id'] ?? null,
                    'quantity' => $item['quantity'],
                    'price_at_time' => $item['price_at_time'],
                ]);
            })->all();

            $this->orderItemRepository->createMany($orderItems);
            $cart = $this->cartRepository->findByUserId($userId);
            $this->deleteSelectedCartItemsService->execute($validatedCartItems, $cart->id);
            $order = $this->orderRepository->findById($orderId);
            $order->items = $orderItems;

            return $order;
        });
    }


}
