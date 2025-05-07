<?php

namespace App\ProductVariant\Domain\Services;

use App\Product\Domain\Contracts\ProductRepositoryPort;
use App\ProductVariant\Domain\Services\GetVariantCombinationsService;
use App\VariantAttributeValue\Domain\Contracts\VariantAttributeValueRepositoryPort;

class GetRemainingVariantSuggestionsService
{
    private GetVariantCombinationsService $getVariantCombinationsService;
    private ProductRepositoryPort $productRepository;
    private VariantAttributeValueRepositoryPort $variantAttributeValueRepository;
    public function __construct(
        GetVariantCombinationsService  $getVariantCombinationsService,
        ProductRepositoryPort $productRepository,
        VariantAttributeValueRepositoryPort $variantAttributeValueRepository
    ) 
    {
        $this->getVariantCombinationsService = $getVariantCombinationsService;
        $this->productRepository = $productRepository;
        $this->variantAttributeValueRepository = $variantAttributeValueRepository;
    }

    public function execute(string $productId): array
    {
        $allCombinations = $this->getVariantCombinationsService->execute($productId);

        return array_values(array_filter($allCombinations, function ($combo) use ($productId) {
            $valueIds = collect($combo['attribute_values'])->pluck('attribute_value_id')->toArray();
            return !$this->variantAttributeValueRepository->existsCombination($productId, $valueIds);
        }));
    }
}
