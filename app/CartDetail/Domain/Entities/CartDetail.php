<?php

namespace App\CartDetail\Domain\Entities;

class CartDetail
{
    public $id;
    public $product_id;
    public $quantity;
    public $price_at_time;
    public $cart_id;
    public $user_id;
    public $created_at;
    public $updated_at;
    

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->product_id = $data['product_id'] ?? null;
        $this->quantity = $data['quantity'] ?? null;
        $this->price_at_time = $data['price_at_time'] ?? null;
        $this->cart_id = $data['cart_id'] ?? null;
        $this->user_id = $data['user_id'] ?? null;
        $this->created_at = $data['created_at'] ?? null;
        $this->updated_at = $data['updated_at'] ?? null;
        
    }
}
