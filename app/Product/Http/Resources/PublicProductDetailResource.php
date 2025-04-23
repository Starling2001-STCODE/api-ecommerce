<?php

namespace App\Product\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Number;

class PublicProductDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'type' => 'products',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'description' => $this->description,
                'brand' => $this->brand,
                'sale_price' => Number::currency($this->sale_price, in: 'DOP'),
                'status' => $this->status,
                'featured' => $this->featured,
                'ratingAverage' => $this->rating_average,
                'tags' => $this->tags,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
            ],
            'relationships' => [
                'category' => [
                    'id' => $this->category['id'] ?? null,
                    'name' => $this->category['name'] ?? null,
                ],
                'size' => [
                    'id' => $this->size['id'] ?? null,
                    'name' => $this->size['name'] ?? null,
                ],
            ],
            'images' => collect($this->images ?? [])->map(fn ($img) => [
                'id' => $img['id'],
                'url' => $img['url'],
                'is_main' => $img['is_main'],
            ]),
            'meta' => [
                'requiresVariants' => $this->getMeta('requires_variants'),
                'existingVariants' => $this->variants,
            ],
            'links' => [
                'self' => route('publicproducts.public.show', ['product' => $this->id]),
            ],
        ];
    }
}
