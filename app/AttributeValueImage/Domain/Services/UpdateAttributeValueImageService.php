<?php

namespace App\AttributeValueImage\Domain\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\AttributeValueImage\Domain\Contracts\AttributeValueImageRepositoryPort;
use Illuminate\Support\Str;


class UpdateAttributeValueImageService
{
    private AttributeValueImageRepositoryPort $attributeValueImageRepository;

    public function __construct(
        AttributeValueImageRepositoryPort $attributeValueImageRepository) 
    {
        $this->attributeValueImageRepository = $attributeValueImageRepository;
    }

    /**
     * @param string $productId
     * @param UploadedFile[] $images
     */
    public function execute(string $productId, string $attributeValueId, string $productName, array $images): void
    {
        foreach ($images as $index => $image) {
            $extension = $image->getClientOriginalExtension();
           
            $slug =  Str::slug(trim($productName));
            $timestamp = now()->format('YmdHisv');
            
            $imageName = "{$slug}-{$timestamp}.{$extension}";
            $path = Storage::disk('public')->putFileAs(
                "imgAttrValue/{$productId}",
                $image,
                $imageName
            );
            $url = Storage::url($path);
            $this->attributeValueImageRepository->create(
                productId: $productId,
                attributeValueId: $attributeValueId,
                url: $url,
                isMain: $index === 0
            );
        }
    }
}
