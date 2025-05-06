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
            'sale_price' => Number::currency(
    optional($this->variants?->firstWhere(fn ($variant) => 
                    $variant->inventory && $variant->inventory->quantity > 0
                ))->price ?? $this->sale_price,
                in: 'DOP', 
                locale: 'es_DO'
            ),
            'brand' => $this->brand,
            'stock_warning' => $this->when(
                $this->inventory && $this->inventory->quantity,
                fn () => [
                    'quantity' => $this->inventory->quantity,
                    'minimum_stock' => $this->inventory->minimum_stock,
                ],
                    $this->when(
                    $this->previewVariant && $this->previewVariant->inventory
                    && $this->previewVariant->inventory->quantity <= $this->previewVariant->inventory->minimum_stock,
                    fn () => [
                        'quantity' => $this->previewVariant->inventory->quantity,
                        'minimum_stock' => $this->previewVariant->inventory->minimum_stock,
                    ]
                )
            ),
            'weight' => $this->weight,
            'dimensions' => $this->dimensions,
            'featured' => $this->featured,
            'status' => $this->status,
            'rating_average' => $this->rating_average,
            'tags' => $this->tags,
            'category' => [
                'id' => $this->category['id'] ?? null,
                'name' => $this->category['name'] ?? null,
            ],
            'size' => [
                'id' => $this->size['id'] ?? null,
                'name' => $this->size['name'] ?? null,
            ],
            'images' => collect($this->limitedImages ?? [])->map(function ($img) {
                return [
                    'id' => $img->id,
                    'url' => $img->url,
                ];
            }),
            'preview_variant_images' => optional($this->previewVariant)->previewImages?->map(function ($img) {
                return [
                    'id' => $img->id,
                    'url' => $img->url,
                ];
            }),
            'attribute_value_preview_images' => $this->attributeValuePreviewImages?->map(function ($img) {
                return [
                    'id' => $img->id,
                    'url' => $img->url,
                ];
            }),       
            'links' => [
                'self' => route('publicproducts.public.show', ['product' => $this->id]),
            ],
        ];
    }
}

