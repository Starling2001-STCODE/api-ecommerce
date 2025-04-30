<?php

namespace App\Product\Http\Resources;

use App\Category\Http\Resources\CategoryResource;
use App\Size\Http\Resources\SizeResource;
use App\AttrCategory\Adapters\Repositories\AttrCategoryRepository;
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
                'name' => $this->resource->name,
                'description' => $this->description,
                'brand' => $this->brand,
                'salePrice' => Number::currency($this->sale_price, in: 'DOP', locale: 'es_DO'),
                'costPrice' => Number::currency($this->cost_price, in: 'DOP', locale: 'es_DO'),
                'status' => $this->status,
                'featured' => $this->featured,
                'ratingAverage' => $this->rating_average,
                'tags' => $this->tags,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
            ],

            'links' => [
                'self' => route('products.show', ['product' => $this->resource->id]),
            ],

            'relationships' => $this->when(
                $request->routeIs('products.show') ||
                $request->routeIs('products.index'),
                fn () => [
                    'category' => new CategoryResource((object) $this->category),
                    'size' => new SizeResource((object) $this->size),
                ]
            ),
            'images' => collect($this->images ?? [])->map(fn ($img) => [
                'id' => $img['id'],
                'url' => $img['url'],
                'is_main' => $img['is_main'],
            ]),
            'meta' => $this->when(
                $request->routeIs('products.index') ||
                $request->routeIs('products.show') ||
                $request->routeIs('products.store'),
                function () use ($request) {
                    $meta = [];

                    $meta['requiresVariants'] = app(AttrCategoryRepository::class)->catReqAttr($this->category_id);
                    $meta['images'] = collect($this->limitedImages ?? [])->map(fn ($img) => [
                        'id' => $img->id,
                        'url' => $img->url,
                    ]);
                    $meta['previewVariantImages'] = optional($this->previewVariant)->previewImages?->map(fn ($img) => [
                        'id' => $img->id,
                        'url' => $img->url,
                    ]);
                    $meta['attributeValuePreviewImages'] = $this->attributeValuePreviewImages?->map(fn ($img) => [
                        'id' => $img->id,
                        'url' => $img->url,
                    ])->values() ?? [];
                    if ($request->routeIs('products.show') || $request->routeIs('products.store')) {
                        $meta['variantSuggestions'] = $this->getMeta('variant_suggestions');
                    }

                    return $meta;
                }
            ),

        ];
    }
}
