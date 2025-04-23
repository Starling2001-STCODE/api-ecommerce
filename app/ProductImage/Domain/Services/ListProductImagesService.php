<?php
namespace App\ProductImage\Domain\Services;
use App\ProductImage\Domain\Contracts\ProductImageRepositoryPort;

class ListProductImagesService
{
    private ProductImageRepositoryPort $productImageRepository;

    public function __construct(
        ProductImageRepositoryPort $productImageRepository) 
    {
        $this->productImageRepository = $productImageRepository;
    }

    public function execute(string $productId): Array
    {
        return $this->productImageRepository->findByProductId($productId);
    }
    
}

