<?php

namespace App\Attribute\Domain\Entities;

class Attributes
{
    /**
     * Create a new class instance.
     */
    public $id;
    public $name;
    public $created_at;
    public $updated_at;
    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'];
        $this->created_at = $data['created_at'] ?? null;
        $this->updated_at = $data['updated_at'] ?? null;
    }

}
