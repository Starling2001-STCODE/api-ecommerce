<?php

namespace App\AttributeValueImage\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributeValueImageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'type' => 'attributeValueImage',
            'id' => $this->id,
            'attributes' => [
                'productId' => $this->product_id,
                'attributeValueId' => $this->attribute_value_id,
                'url' => $this->url,
                'isMain' => $this->is_main,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
            ],
        ];
    }
}
