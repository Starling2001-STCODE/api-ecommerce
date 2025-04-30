<?php

namespace App\Order\Domain\Contracts;

use App\Order\Domain\Entities\OrderItem;

interface OrderItemRepositoryPort
{
    public function create(OrderItem $orderItem): OrderItem;
    public function createMany(array $orderItems): void;
    public function findByOrderId(string $orderId): array;
    public function deleteByOrderId(string $orderId): void;
}
