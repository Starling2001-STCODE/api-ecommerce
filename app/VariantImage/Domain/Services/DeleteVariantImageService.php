<?php

namespace App\VariantImage\Domain\Services;
use App\VariantImage\Domain\Contracts\VariantImageRepositoryPort;


class DeleteVariantImageService
{
    private VariantImageRepositoryPort $variantImageRepository;

    public function __construct(
        VariantImageRepositoryPort $variantImageRepository) 
    {
        $this->variantImageRepository = $variantImageRepository;
    }
    
    public function execute(string $imageId): void
    {
        $this->variantImageRepository->delete($imageId);
    }
}
