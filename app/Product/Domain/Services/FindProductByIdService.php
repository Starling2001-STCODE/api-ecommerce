<?php

namespace App\Product\Domain\Services;

use App\Product\Domain\Contracts\ProductRepositoryPort;
use App\ProductImage\Domain\Contracts\ProductImageRepositoryPort;
use App\ProductVariant\Domain\Services\GetRemainingVariantSuggestionsService;
use App\ProductVariant\Domain\Services\GetProductVariantsService;
use App\AttrCategory\Adapters\Repositories\AttrCategoryRepository;
use App\Product\Domain\Entities\Product;

class FindProductByIdService
{
    private ProductRepositoryPort $productRepository;
    private AttrCategoryRepository $attrCategoryRepository;
    private GetRemainingVariantSuggestionsService $getRemainingVariantSuggestionsService;
    private GetProductVariantsService $getProductVariantsService;
    private ProductImageRepositoryPort $productImageRepository;

    public function __construct(
        ProductRepositoryPort $productRepository,
        AttrCategoryRepository $attrCategoryRepository,
        GetRemainingVariantSuggestionsService $getRemainingVariantSuggestionsService,
        GetProductVariantsService $getProductVariantsService,
        ProductImageRepositoryPort $productImageRepository,)
    {
        $this->productRepository = $productRepository;
        $this->attrCategoryRepository = $attrCategoryRepository;
        $this->getRemainingVariantSuggestionsService = $getRemainingVariantSuggestionsService;
        $this->getProductVariantsService = $getProductVariantsService;
        $this->productImageRepository = $productImageRepository;
    }

    public function execute(string $id, bool $loadSuggestions = true): Product
    {
        $product = $this->productRepository->findById($id);
    
        $requiresVariants = $this->attrCategoryRepository->catReqAttr($product->category_id);
        $product->setMeta('requires_variants', $requiresVariants);
    
        if ($requiresVariants && $loadSuggestions) {
            $variantSuggestions = $this->getRemainingVariantSuggestionsService->execute($product->id);
            $product->setMeta('variant_suggestions', $variantSuggestions);
        }
        return $product;
    }
}
