<?php

namespace App\AttributeValueImage\Domain\Services;
use App\AttributeValueImage\Domain\Contracts\AttributeValueImageRepositoryPort;


class DeleteVariantImageService
{
    private AttributeValueImageRepositoryPort $attributeValueImageRepository;

    public function __construct(
        AttributeValueImageRepositoryPort $attributeValueImageRepository) 
    {
        $this->attributeValueImageRepository = $attributeValueImageRepository;
    }
    
    public function execute(string $imageId): void
    {
        $this->attributeValueImageRepository->delete($imageId);
    }
}
