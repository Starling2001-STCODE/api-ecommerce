<?php

namespace App\ProductImage\Adapters\Controllers;

use App\Core\Controllers\BaseController; 
use Illuminate\Http\JsonResponse;
use App\ProductImage\Http\Requests\UploadProductImageRequest;
use App\ProductImage\Http\Resources\ProductImageResource;
use App\ProductImage\Domain\Services\UploadProductImageService;
use App\ProductImage\Domain\Services\ListProductImagesService;
use App\ProductImage\Domain\Services\DeleteProductImageService;

class ProductImageController extends BaseController
{
    private UploadProductImageService $uploadProductImageService;
    private ListProductImagesService $listProductImagesService;
    private DeleteProductImageService $deleteProductImageService;

    public function __construct(
        UploadProductImageService $uploadProductImageService,
        ListProductImagesService $listProductImagesService,
        DeleteProductImageService $deleteProductImageService,
    ) {
        $this->uploadProductImageService = $uploadProductImageService;
        $this->listProductImagesService = $listProductImagesService;
        $this->deleteProductImageService = $deleteProductImageService;
    }

    public function upload(string $productId, UploadProductImageRequest $request): JsonResponse
    {
        $productName = $request->input('product_name');
        $images = $request->file('images');

        $this->uploadProductImageService->execute($productId, $productName, $images);

        return response()->json([
            'message' => 'Imágenes subidas correctamente.',
        ], 201);
    }

    public function showByProductId(string $productId): JsonResponse
    {
        $images = $this->listProductImagesService->execute($productId);

        return response()->json([
            'data' => ProductImageResource::collection($images),
            'meta' => [
                'total' => count($images),
            ]
        ]);
    }
    public function delete(string $imageId): JsonResponse
    {
        $this->deleteProductImageService->execute($imageId);

        return response()->json([
            'message' => 'Imagen eliminada correctamente.'
        ]);
    }
}
