<?php

namespace App\AttributeValueImage\Adapters\Controllers;
use App\Core\Controllers\BaseController; 
use Illuminate\Http\JsonResponse;
use App\AttributeValueImage\Http\Requests\CreateAttributeValueImageRequest;
use App\AttributeValueImage\Http\Resources\AttributeValueImageResource;
use App\AttributeValueImage\Domain\Services\DeleteVariantImageService;
use App\AttributeValueImage\Domain\Services\ListAttributeValueImagesService;
use App\AttributeValueImage\Domain\Services\UpdateAttributeValueImageService;
use Illuminate\Http\Request;


class AttributeValueImageController extends BaseController
{
    private UpdateAttributeValueImageService $updateAttributeValueImageService;
    private ListAttributeValueImagesService $listAttributeValueImagesService;
    private DeleteVariantImageService $deleteVariantImageService;

    public function __construct(
        UpdateAttributeValueImageService $updateAttributeValueImageService,
        ListAttributeValueImagesService $listAttributeValueImagesService,
        DeleteVariantImageService $deleteVariantImageService,
    ) {
        $this->updateAttributeValueImageService = $updateAttributeValueImageService;
        $this->listAttributeValueImagesService = $listAttributeValueImagesService;
        $this->deleteVariantImageService = $deleteVariantImageService;
    }

    public function upload(string $productId, string $attributeValueId, CreateAttributeValueImageRequest $request): JsonResponse
    {
        $sku = $request->input('sku');
        $images = $request->file('images');

        $this->updateAttributeValueImageService->execute($productId, $attributeValueId, $sku, $images);

        return response()->json([
            'message' => 'Imágenes subidas correctamente.',
        ], 201);
    }

    public function showByProductId(Request $request, string $productId): JsonResponse
    {
        $attributeValueId = $request->query('attribute_value_id');
    
        $images = $this->listAttributeValueImagesService->execute($productId, $attributeValueId);
    
        return response()->json([
            'data' => AttributeValueImageResource::collection($images),
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