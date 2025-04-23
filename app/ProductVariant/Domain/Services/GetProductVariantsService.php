<?php

namespace App\ProductVariant\Domain\Services;

use App\ProductVariant\Domain\Contracts\ProductVariantRepositoryPort;
use App\ProductVariant\Domain\Entities\ProductVariant;
use Illuminate\Support\Collection;

class GetProductVariantsService
{
    public function __construct(
        private ProductVariantRepositoryPort $productVariantRepository
    ) {}

    public function execute(string $productId): Collection
    {
        $variantModels = $this->productVariantRepository->getVariantsByProductId($productId);

        return $variantModels->map(function ($variantModel): ProductVariant {
            return new ProductVariant([
                'id'             => $variantModel->id,
                'product_id'     => $variantModel->product_id,
                'sku'            => $variantModel->sku,
                'price'          => $variantModel->price,
                'cost_price'     => $variantModel->cost_price,
                'sale_price'     => $variantModel->sale_price,
                'is_active'      => $variantModel->is_active,
                'created_at'     => $variantModel->created_at,
                'updated_at'     => $variantModel->updated_at,
                'stock'          => optional($variantModel->inventory)->quantity,
                'minimum_stock'  => optional($variantModel->inventory)->minimum_stock,
                'attribute_values' => collect($variantModel->attributeValues)->map(function ($attrVal) {
                    return [
                        'attribute_id'         => $attrVal->attribute->id ?? null,
                        'attribute_name'       => $attrVal->attribute->name ?? null,
                        'attribute_value_id'   => $attrVal->id,
                        'attribute_value_name' => $attrVal->value,
                        'images' => collect($attrVal->images)->map(function ($image) {
                            return [
                                'id' => $image->id,
                                'url' => $image->url,
                                'is_main' => $image->is_main,
                                'created_at' => $image->created_at,
                                'updated_at' => $image->updated_at,
                            ];
                        })->toArray(),
                    ];
                }),
                'images' => collect($variantModel->images)->map(function ($image) {
                    return [
                        'id' => $image->id,
                        'url' => $image->url,
                        'is_main' => $image->is_main,
                        'created_at' => $image->created_at,
                        'updated_at' => $image->updated_at,
                    ];
                })->toArray()
            ]);
        });        
    }
}
