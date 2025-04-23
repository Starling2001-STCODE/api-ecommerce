<?php

namespace App\ProductImage\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductImageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'type' => 'productImage',
            'id' => $this->id,
            'attributes' => [
                'url' => $this->url,
                'isMain' => $this->is_main,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
            ],
        ];
    }
}
