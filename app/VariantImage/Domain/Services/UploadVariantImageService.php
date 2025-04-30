<?php

namespace App\VariantImage\Domain\Services;
use App\VariantImage\Domain\Contracts\VariantImageRepositoryPort;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class UploadVariantImageService
{
    private VariantImageRepositoryPort $variantImageRepository;

    public function __construct(
        VariantImageRepositoryPort $variantImageRepository) 
    {
        $this->variantImageRepository = $variantImageRepository;
    }
     /**
     * @param string $productId
     * @param UploadedFile[] $images
     */
    public function execute(string $variantId, string $sku, array $images): void
    {
        foreach ($images as $index => $image) {
            $extension = $image->getClientOriginalExtension();
           
            $slug =  Str::slug(trim($sku));
            $timestamp = now()->format('YmdHisv');
            
            $imageName = "{$slug}-{$timestamp}.{$extension}";
            $path = Storage::disk('public')->putFileAs(
                "imgProductVariant/{$variantId}",
                $image,
                $imageName
            );
            $url = Storage::url($path);
            $this->variantImageRepository->create(
                variantId: $variantId,
                url: $url,
                isMain: $index === 0
            );
        }
    }
}