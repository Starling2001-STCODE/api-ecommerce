<?php

namespace App\Product\Adapters\Controllers;

use App\Core\Controllers\BaseController; 
use App\Product\Domain\Services\FindProductByIdService;
use App\Product\Domain\Services\ListProductsService;
use App\Product\Http\Resources\PublicProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductPublicController extends BaseController
{
    private FindProductByIdService $findProductByIdService;
    private ListProductsService $listProductsService;
    public function __construct(
        FindProductByIdService $findProductByIdService,
        ListProductsService $listProductsService
        )
    {
        $this->findProductByIdService = $findProductByIdService;
        $this->listProductsService = $listProductsService;
    }
    public function getProductPublic(Request $request)
    {
        $perPege = $this->getPerPage($request);
        $product = $this->listProductsService->execute($perPege);
        return PublicProductResource::collection($product);   
    }
    public function showProductPublic(string $id): JsonResponse
    {
        $product = $this->findProductByIdService->execute($id);
        return (new PublicProductResource($product))
            ->response()
            ->setStatusCode(200);
    }

}
