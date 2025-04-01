<?php
namespace App\Product\Http\Resources;

use App\Category\Http\Resources\CategoryResource;
use App\Size\Http\Resources\SizeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Number;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'type' => 'products',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'description' => $this->description,
                'sku' => $this->sku,
                'brand' => $this->brand,
                'salePrice' => Number::currency($this->sale_price, in: 'USD', locale: 'en_US'),
                'costPrice' => Number::currency($this->cost_price, in: 'DOP', locale: 'es_DO'),
                'weight' => $this->weight,
                'dimensions' => $this->dimensions,
                'status' => $this->status,
                'featured' => $this->featured,
                'ratingAverage' => $this->rating_average,
                'tags' => $this->tags,
                'img' => $this->img,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
            ],

            'links' => [
                'self' => route('products.show', ['product' => $this->id]),
            ],

            'relationships' => $this->when(
                $request->routeIs('products.show') ||
                $request->routeIs('products.index'),
                fn () => [
                    'category' => new CategoryResource((object) $this->category),
                    'size' => new SizeResource((object) $this->size),
                ]
            ),
        ];
    }
}
