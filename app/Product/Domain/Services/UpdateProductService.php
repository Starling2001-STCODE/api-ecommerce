<?php

namespace App\Product\Domain\Services;

use App\Product\Domain\Contracts\ProductRepositoryPort;
use App\ProductVariant\Domain\Services\GetRemainingVariantSuggestionsService;
use App\ProductVariant\Domain\Services\GetProductVariantsService;
use App\AttrCategory\Adapters\Repositories\AttrCategoryRepository;

use App\Product\Domain\Entities\Product;

class UpdateProductService
{
    private ProductRepositoryPort $productRepository;
    private AttrCategoryRepository $attrCategoryRepository;
    private GetRemainingVariantSuggestionsService $getRemainingVariantSuggestionsService;
    private GetProductVariantsService $getProductVariantsService;

    public function __construct(
        ProductRepositoryPort $productRepository,
        AttrCategoryRepository $attrCategoryRepository,
        GetRemainingVariantSuggestionsService $getRemainingVariantSuggestionsService,
        GetProductVariantsService $getProductVariantsService,
        )
    {
        $this->productRepository = $productRepository;
        $this->attrCategoryRepository = $attrCategoryRepository;
        $this->getRemainingVariantSuggestionsService = $getRemainingVariantSuggestionsService;
        $this->getProductVariantsService = $getProductVariantsService;
    }

    public function execute(string $id, array $data): Product
    {
        $product = $this->productRepository->update($id, $data);

        $requiresVariants = $this->attrCategoryRepository->catReqAttr($product->category_id);
        $product->setMeta('requires_variants', $requiresVariants);

        if ($requiresVariants) {
            $variantSuggestions = $this->getRemainingVariantSuggestionsService->execute($product->id);
            $product->setMeta('variant_suggestions', $variantSuggestions);
        }

        return $product;
    }
}
