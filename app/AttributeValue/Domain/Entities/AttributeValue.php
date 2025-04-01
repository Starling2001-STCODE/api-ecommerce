<?php

namespace App\AttributeValue\Domain\Entities;

class AttributeValue
{
    public $id;
    public $attribute_id;
    public $value;
    public $created_at;
    public $updated_at;
    public $attribute;
    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->attribute_id = $data['attribute_id'];
        $this->value = $data['value'];
        $this->created_at = $data['created_at'] ?? null;
        $this->updated_at = $data['updated_at'] ?? null;
        $this->attribute = $data['attribute'] ?? null;
    }
}
