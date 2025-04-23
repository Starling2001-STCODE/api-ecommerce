<?php

namespace App\AttributeValueImage\Domain\Entities;

class AttributeValueImage
{
    public string $id;
    public string $product_id;
    public string $attribute_value_id;
    public string $url;
    public bool $is_main;
    public string $created_at;
    public string $updated_at;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->product_id = $data['product_id'] ?? null;
        $this->attribute_value_id = $data['attribute_value_id'] ?? null;
        $this->url = $data['url'] ?? null;
        $this->is_main = $data['is_main'] ?? false;
        $this->created_at = $data['created_at'] ?? null;
        $this->updated_at = $data['updated_at'] ?? null;
    }
}
