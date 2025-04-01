<?php

namespace App\AttributeValue\Domain\Services;

use App\AttributeValue\Domain\Contracts\AttributeValueRepositoryPort;
use App\AttributeValue\Domain\Entities\AttributeValue;

class UpdateAttributeValueService
{
    private AttributeValueRepositoryPort $attributeValueRepository;
    public function __construct(AttributeValueRepositoryPort $attributeValueRepository)
    {
        $this->attributeValueRepository = $attributeValueRepository;
    }
    public function execute(string $id, array $data): AttributeValue
    {
        return $this->attributeValueRepository->update($id, $data);
    }
}
