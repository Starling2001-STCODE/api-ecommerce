<?php
namespace App\ProductVariant\Domain\Services;

use App\AttrCategory\Adapters\Repositories\AttrCategoryRepository;
use App\Product\Domain\Contracts\ProductRepositoryPort;
use Illuminate\Support\Str;

class GetVariantCombinationsService
{
    public function __construct(
        private AttrCategoryRepository $attrCategoryRepo,
        private ProductRepositoryPort $productRepo
    ) {}

    public function execute(string $productId): array
    {
        $product = $this->productRepo->findById($productId);
        $attributes = $this->attrCategoryRepo->getRequiredAttributesByCategory($product->category_id);

        $combinationsData = [];
        foreach ($attributes as $attribute) {
            $combinationsData[] = $attribute->values->map(function ($val) use ($attribute) {
                return [
                    'attribute_id' => $attribute->id,
                    'attribute_name' => $attribute->name,
                    'attribute_value_id' => $val->id,
                    'attribute_value_name' => $val->value
                ];
            })->toArray();
        }

        $combinations = $this->generateCombinations($combinationsData);

        $combinationsWithSku = array_map(function ($combo) use ($product) {
            $sku = strtoupper(Str::slug($product->name));
            foreach ($combo as $attr) {
                $sku .= '-' . strtoupper(Str::slug($attr['attribute_value_name']));
            }
            return [
                'sku' => $sku,
                'attribute_values' => $combo
            ];
        }, $combinations);

        return $combinationsWithSku;
    }

    private function generateCombinations(array $arrays): array
    {
        $result = [[]];
        foreach ($arrays as $propertyValues) {
            $append = [];
            foreach ($result as $product) {
                foreach ($propertyValues as $item) {
                    $append[] = array_merge($product, [$item]);
                }
            }
            $result = $append;
        }
        return $result;
    }
}
