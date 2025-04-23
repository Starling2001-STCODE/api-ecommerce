<?php
namespace App\Product\Http\Resources;

use App\Category\Http\Resources\CategoryResource;
use App\Size\Http\Resources\SizeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Number;

class ProductDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'type' => 'products',
            'id' => $this->resource->id,
            'attributes' => [
                'name' => $this->resource->name,
                'description' => $this->resource->description,
                'brand' => $this->resource->brand,
                'salePrice' => $this->resource->sale_price,
                'costPrice' => $this->resource->cost_price,
                'status' => $this->resource->status,
                'featured' => $this->resource->featured,
                'ratingAverage' => $this->resource->rating_average,
                'tags' => $this->resource->tags,
                'createdAt' => $this->resource->created_at,
                'updatedAt' => $this->resource->updated_at,
            ],
            'links' => [
                'self' => route('products.show', ['product' => $this->resource->id]),
            ],
            'relationships' => [
                'category' => $this->resource->category,
                'size' => $this->resource->size,
            ],
            'inventoryProductSimple' => [
                'inventory' => $this->resource->inventory,
            ],
            'images' => collect($this->images ?? [])->map(fn ($img) => [
                'id' => $img['id'],
                'url' => $img['url'],
                'is_main' => $img['is_main'],
            ]),
            'meta' => [
                'requiresVariants' => $this->resource->getMeta('requires_variants'),
                'existingVariants' => $this->resource->variants,
                'variantSuggestions' => $this->resource->getMeta('variant_suggestions'),
            ],
        ];
    }
}
