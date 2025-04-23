<?php

namespace App\VariantImage\Adapters\Controllers;
use App\Core\Controllers\BaseController; 
use Illuminate\Http\JsonResponse;
use App\VariantImage\Http\Requests\UploadVariantImageRequest;
use App\VariantImage\Http\Resources\VariantImageResource;
use App\VariantImage\Domain\Services\DeleteVariantImageService;
use App\VariantImage\Domain\Services\ListVariantImagesService;
use App\VariantImage\Domain\Services\UploadVariantImageService;


class VariantImageController extends BaseController
{
    private UploadVariantImageService $uploadVariantImageService;
    private ListVariantImagesService $listVariantImagesService;
    private DeleteVariantImageService $deleteVariantImageService;

    public function __construct(
        UploadVariantImageService $uploadVariantImageService,
        ListVariantImagesService $listVariantImagesService,
        DeleteVariantImageService $deleteVariantImageService,
    ) {
        $this->uploadVariantImageService = $uploadVariantImageService;
        $this->listVariantImagesService = $listVariantImagesService;
        $this->deleteVariantImageService = $deleteVariantImageService;
    }

    public function upload(string $variantId, UploadVariantImageRequest $request): JsonResponse
    {
        $sku = $request->input('sku');
        $images = $request->file('images');

        $this->uploadVariantImageService->execute($variantId, $sku, $images);

        return response()->json([
            'message' => 'Imágenes subidas correctamente.',
        ], 201);
    }

    public function showByVariantId(string $variantId): JsonResponse
    {
        $images = $this->listVariantImagesService->execute($variantId);

        return response()->json([
            'data' => VariantImageResource::collection($images),
            'meta' => [
                'total' => count($images),
            ]
        ]);
    }
    public function delete(string $imageId): JsonResponse
    {
        $this->deleteVariantImageService->execute($imageId);

        return response()->json([
            'message' => 'Imagen eliminada correctamente.'
        ]);
    }
}
