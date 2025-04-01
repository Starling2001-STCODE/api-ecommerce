<?php
namespace App\Product\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Number;

class PublicProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'sale_price' => Number::currency($this->sale_price, in: 'DOP'),
            'sku' => $this->sku,
            'brand' => $this->brand,
            'weight' => $this->weight,
            'dimensions' => $this->dimensions,
            'featured' => $this->featured,
            'rating_average' => $this->rating_average,
            'tags' => $this->tags,
            'img' => $this->img,
            'category' => [
                'id' => $this->category['id'] ?? null,
                'name' => $this->category['name'] ?? null,
            ],
            'size' => [
                'id' => $this->size['id'] ?? null,
                'name' => $this->size['name'] ?? null,
            ],
            'links' => [
                'self' => route('products.public.show', ['product' => $this->id]),
            ],
        ];
    }
}

