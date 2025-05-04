<?php

namespace App\Inventory\Domain\Entities;
class Inventory
{
    public $id;
    public $product_id;
    public $product_variant_id;
    public $quantity;
    public $minimum_stock;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->product_id = $data['product_id'] ?? null;
        $this->product_variant_id = $data['product_variant_id'] ?? null;
        $this->quantity = $data['quantity'] ?? 0;
        $this->minimum_stock = $data['minimum_stock'] ?? 0;
    }
}

