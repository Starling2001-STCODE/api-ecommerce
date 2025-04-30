<?php

namespace App\Order\Adapters\Repositories;

use App\Models\OrderItem as OrderItemModel;
use App\Order\Domain\Contracts\OrderItemRepositoryPort;
use App\Order\Domain\Entities\OrderItem;
use Illuminate\Support\Arr;

class OrderItemRepository implements OrderItemRepositoryPort
{
    public function create(OrderItem $orderItem): OrderItem
    {
        $model = OrderItemModel::create([
            'id' => $orderItem->id,
            'order_id' => $orderItem->order_id,
            'product_id' => $orderItem->product_id,
            'variant_id' => $orderItem->variant_id,
            'quantity' => $orderItem->quantity,
            'price_at_time' => $orderItem->price_at_time,
        ]);

        return new OrderItem($model->toArray());
    }

    public function createMany(array $orderItems): void
    {
        $data = array_map(function (OrderItem $item) {
            return [
                'id' => $item->id,
                'order_id' => $item->order_id,
                'product_id' => $item->product_id,
                'variant_id' => $item->variant_id,
                'quantity' => $item->quantity,
                'price_at_time' => $item->price_at_time,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $orderItems);

        OrderItemModel::insert($data);
    }

    public function findByOrderId(string $orderId): array
    {
        $models = OrderItemModel::where('order_id', $orderId)->get();
        return $models->map(fn($m) => new OrderItem($m->toArray()))->toArray();
    }

    public function deleteByOrderId(string $orderId): void
    {
        OrderItemModel::where('order_id', $orderId)->delete();
    }
}

