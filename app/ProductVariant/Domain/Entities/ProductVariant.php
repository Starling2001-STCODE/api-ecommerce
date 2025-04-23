<?php

namespace App\ProductVariant\Domain\Entities;

class ProductVariant
{
    public ?string $id;
    public ?string $product_id;
    public ?string $sku;
    public ?float $price;
    public ?float $cost_price;
    public ?float $sale_price;
    public bool $is_active;
    public ?string $created_at;
    public ?string $updated_at;
    public array $attribute_values = [];
    public array $images = [];

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->product_id = $data['product_id'] ?? null;
        $this->sku = $data['sku'] ?? null;
        $this->price = $data['price'] ?? null;
        $this->cost_price = $data['cost_price'] ?? null;
        $this->sale_price = $data['sale_price'] ?? null;
        $this->is_active = $data['is_active'] ?? true;
        $this->created_at = $data['created_at'] ?? null;
        $this->updated_at = $data['updated_at'] ?? null;
        $this->attribute_values = $data['attribute_values'] ?? [];
        $this->images = $data['images'] ?? [];
    }
}

