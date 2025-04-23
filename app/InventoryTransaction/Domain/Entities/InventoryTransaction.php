<?php

namespace App\InventoryTransaction\Domain\Entities;

class InventoryTransaction
{
    public $id;
    public $type;
    public $ncf;
    public $invoice_number;
    public $note;
    public $product_id;
    public $product_variant_id;
    public $user_id;
    public $user = [];
    public $created_at;
    public $updated_at;
    public $products = [];

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->type = $data['type'];
        $this->ncf = $data['ncf'] ?? null;
        $this->invoice_number = $data['invoice_number'] ?? null;
        $this->note = $data['note'] ?? null;
        $this->product_id = $data['product_id'] ?? null;
        $this->product_variant_id = $data['product_variant_id'] ?? null;
        $this->user_id = $data['user_id'];
        $this->created_at = $data['created_at'] ?? null;
        $this->updated_at = $data['updated_at'] ?? null;
        $this->products = $data['products'] ?? [];
        $this->user = $data['user'] ?? [];
    }
}
