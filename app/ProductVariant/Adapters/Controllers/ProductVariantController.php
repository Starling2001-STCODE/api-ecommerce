<?php

namespace App\ProductVariant\Adapters\Controllers;
use App\Core\Controllers\BaseController; 
use App\ProductVariant\Domain\Contracts\ProductVariantRepositoryPort;
use App\ProductVariant\Domain\Services\CreateProductVariantService;
use App\ProductVariant\Http\Requests\CreateProductVariantRequest;
use App\ProductVariant\Http\Resources\ProductVariantResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class ProductVariantController extends BaseController
{
    private CreateProductVariantService $createProductVariantService;
    private ProductVariantRepositoryPort $productVariantRepository;
    public function __construct(CreateProductVariantService $createProductVariantService, 
    ProductVariantRepositoryPort $productVariantRepository)
    {
       $this->createProductVariantService = $createProductVariantService;
       $this->productVariantRepository = $productVariantRepository;
    }
    public function store(CreateProductVariantRequest $createProductVariantRequest, string $productId): JsonResponse
    {
        $data = $createProductVariantRequest->validated();
        $product = $this->createProductVariantService->execute($productId, $data);
        return ProductVariantResource::collection($product)
        ->response()
        ->setStatusCode(201);
    }
    public function destroy(string $productId, string $variantId): JsonResponse
    {
        $this->productVariantRepository->delete($variantId);
    
        return response()->json([
            'message' => 'Variante eliminada correctamente.'
        ], 200);
    }
}
