<?php

namespace App\ProductImage\Domain\Services;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\ProductImage\Domain\Contracts\ProductImageRepositoryPort;
use Illuminate\Support\Str;


class UploadProductImageService
{
    private ProductImageRepositoryPort $productImageRepository;

    public function __construct(
        ProductImageRepositoryPort $productImageRepository) 
    {
        $this->productImageRepository = $productImageRepository;
    }

    /**
     * @param string $productId
     * @param UploadedFile[] $images
     */
    public function execute(string $productId, string $productName, array $images): void
    {
        foreach ($images as $index => $image) {
            $extension = $image->getClientOriginalExtension();
           
            $slug =  Str::slug(trim($productName));
            $timestamp = now()->timestamp;
            
            $imageName = "{$slug}-{$timestamp}.{$extension}";
            $path = Storage::disk('public')->putFileAs(
                "imgProduct/{$productId}",
                $image,
                $imageName
            );
            $url = Storage::url($path);
            $this->productImageRepository->create(
                productId: $productId,
                url: $url,
                isMain: $index === 0
            );
        }
    }
}