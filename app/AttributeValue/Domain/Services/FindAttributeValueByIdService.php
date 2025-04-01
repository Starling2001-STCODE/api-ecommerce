<?php

namespace App\AttributeValue\Domain\Services;

use App\AttributeValue\Domain\Contracts\AttributeValueRepositoryPort;
use App\AttributeValue\Domain\Entities\AttributeValue;

class FindAttributeValueByIdService
{
    private AttributeValueRepositoryPort $attributeValueRepository;
    public function __construct(AttributeValueRepositoryPort $attributeValueRepository)
    {
        $this->attributeValueRepository = $attributeValueRepository;
    }
    public function execute(string $id): AttributeValue
    {
        return $this->attributeValueRepository->findById($id);
    }
}
