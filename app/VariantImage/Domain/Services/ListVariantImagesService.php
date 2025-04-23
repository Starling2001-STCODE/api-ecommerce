<?php

namespace App\VariantImage\Domain\Services;
use App\VariantImage\Domain\Contracts\VariantImageRepositoryPort;

class ListVariantImagesService
{
    private VariantImageRepositoryPort $variantImageRepository;

    public function __construct(
        VariantImageRepositoryPort $variantImageRepository) 
    {
        $this->variantImageRepository = $variantImageRepository;
    }
    
    public function execute(string $variantId): Array
    {
       return $this->variantImageRepository->findByVariantId($variantId);
    }
}


