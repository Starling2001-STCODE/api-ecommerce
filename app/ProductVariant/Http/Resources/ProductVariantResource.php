<?php

namespace App\ProductVariant\Http\Resources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'type' => 'productVariant',
            'id' => $this->id,
            'attributes' => [
                'sku' => $this->sku,
                'price' => $this->price,
                'costPrice' => $this->cost_price,
                'salePrice' => $this->sale_price,
                'isActive' => $this->is_active,
                'productId' => $this->product_id,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
                'attributeValues' => $this->attribute_values,
            ],
        ];
    }

}
