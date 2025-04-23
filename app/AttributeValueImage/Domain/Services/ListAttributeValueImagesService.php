<?php

namespace App\AttributeValueImage\Domain\Services;
use App\AttributeValueImage\Domain\Contracts\AttributeValueImageRepositoryPort;

class ListAttributeValueImagesService
{
    private AttributeValueImageRepositoryPort $attributeValueImageRepository;

    public function __construct(
        AttributeValueImageRepositoryPort $attributeValueImageRepository) 
    {
        $this->attributeValueImageRepository = $attributeValueImageRepository;
    }
    
    public function execute(string $productId, ?string $attributeValueId = null): array
    {
        return $this->attributeValueImageRepository->getImagesByProductId($productId, $attributeValueId);
    }
}
