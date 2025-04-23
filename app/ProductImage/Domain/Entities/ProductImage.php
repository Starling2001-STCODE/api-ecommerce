<?php

namespace App\ProductImage\Domain\Entities;

class ProductImage
{
        public $id;
        public $product_id;
        public $url;
        public bool $is_main;
        public $created_at;
        public $updated_at;
        

        public function __construct(array $data)
        {
            $this->id = $data['id'] ?? null;
            $this->product_id = $data['product_id'] ?? null;
            $this->url = $data['url'] ?? null;
            $this->is_main = $data['is_main'] ?? null;
            $this->created_at = $data['created_at'] ?? null;
            $this->updated_at = $data['updated_at'] ?? null;
        }
}
