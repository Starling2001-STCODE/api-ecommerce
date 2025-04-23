<?php

namespace App\ProductVariant\Domain\Mappers;

use App\Models\ProductVariant;

class ProductVariantMapper
{
    public static function map(ProductVariant $variantModel): array
    {
        $hasVariantImages = $variantModel->images->isNotEmpty();

        return [
            'id' => $variantModel->id,
            'product_id' => $variantModel->product_id,
            'sku' => $variantModel->sku,
            'price' => $variantModel->price,
            'cost_price' => $variantModel->cost_price,
            'sale_price' => $variantModel->sale_price,
            'is_active' => $variantModel->is_active,
            'created_at' => $variantModel->created_at,
            'updated_at' => $variantModel->updated_at,
            'quantity' => optional($variantModel->inventory)->quantity,
            'minimum_stock' => optional($variantModel->inventory)->minimum_stock,

            'attribute_values' => $variantModel->attributeValues->map(function ($attrVal) {
                return [
                    'attribute_id' => $attrVal->attribute?->id,
                    'attribute_name' => $attrVal->attribute?->name,
                    'attribute_value_id' => $attrVal->id,
                    'attribute_value_name' => $attrVal->value,
                ];
            })->toArray(),

            'images' => $variantModel->images->map(function ($image) {
                return [
                    'id' => $image->id,
                    'url' => $image->url,
                    'is_main' => $image->is_main,
                    'created_at' => $image->created_at,
                    'updated_at' => $image->updated_at,
                ];
            })->toArray(),

            'attribute_value_images' => $hasVariantImages
                ? [] 
                : $variantModel->attributeValues
                    ->flatMap(function ($attrVal) {
                        return $attrVal->images->map(function ($image) {
                            return [
                                'id' => $image->id,
                                'url' => $image->url,
                                'is_main' => $image->is_main,
                                'created_at' => $image->created_at,
                                'updated_at' => $image->updated_at,
                            ];
                        });
                    })
                    ->values()
                    ->unique('url')
                    ->toArray(),
        ];
    }
}
