<?php

namespace App\Product\Domain\Services;
use App\Product\Domain\Contracts\ProductRepositoryPort;
use App\AttrCategory\Adapters\Repositories\AttrCategoryRepository;
use App\ProductVariant\Domain\Services\GetVariantCombinationsService;
use App\Product\Domain\Entities\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CreateProductService
{
     private ProductRepositoryPort $productRepository;
     private AttrCategoryRepository $attrCategoryRepository;
     private GetVariantCombinationsService $getVariantCombinationsService;
     public function __construct(
    ProductRepositoryPort $productRepository,
    AttrCategoryRepository $attrCategoryRepository,
    GetVariantCombinationsService $getVariantCombinationsService) 
    {
        $this->productRepository = $productRepository;
        $this->attrCategoryRepository = $attrCategoryRepository;
        $this->getVariantCombinationsService = $getVariantCombinationsService;
    }
    public function execute(array $data): Product
    {
        return DB::transaction(function () use ($data) {
            $identifier = Auth::guard('sanctum')->check()
            ? Auth::guard('sanctum')->id()
            : guest_session();
            $data['user_id'] = $identifier;
            $productEntity = new Product($data);
            $product = $this->productRepository->create($productEntity);

            $requiresVariants = $this->attrCategoryRepository->catReqAttr($product->category_id);
            if ($requiresVariants) {
                $combinations = $this->getVariantCombinationsService->execute($product->id);
                $product->setMeta('requires_variants', true);
                $product->setMeta('variant_suggestions', $combinations);
            } else {
                $product->setMeta('requires_variants', false);
            }
        
            return $product;
        });
    }
}
