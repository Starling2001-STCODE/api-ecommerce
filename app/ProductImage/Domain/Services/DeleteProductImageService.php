<?php

namespace App\ProductImage\Domain\Services;
use App\ProductImage\Domain\Contracts\ProductImageRepositoryPort;

class DeleteProductImageService
{
    private ProductImageRepositoryPort $productImageRepository;

    public function __construct(
        ProductImageRepositoryPort $productImageRepository) 
    {
        $this->productImageRepository = $productImageRepository;
    }
    
    public function execute(string $imageId): void
    {
        $this->productImageRepository->delete($imageId);
    }
}
