<?php

namespace App\Order\Domain\Entities;

class OrderItem
{
    public ?string $id;
    public string $order_id;
    public string $product_id;
    public ?string $variant_id;
    public int $quantity;
    public float $price_at_time;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->order_id = $data['order_id'];
        $this->product_id = $data['product_id'];
        $this->variant_id = $data['variant_id'] ?? null;
        $this->quantity = $data['quantity'];
        $this->price_at_time = $data['price_at_time'];
    }
}
