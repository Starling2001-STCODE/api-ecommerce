<?php

namespace App\AttrCategory\Domain\Entities;

class AttrCategory
{
    public $id;
    public $category_id;
    public $attribute_id;
    public $required;
    public $created_at;
    public $updated_at;
    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->category_id = $data['category_id'];
        $this->attribute_id = $data['attribute_id'];
        $this->required = $data['required'];
        $this->created_at = $data['created_at'] ?? null;
        $this->updated_at = $data['updated_at'] ?? null;
    }
}
