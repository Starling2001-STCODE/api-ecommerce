<?php

namespace App\Attribute\Domain\Services;

use App\Attribute\Domain\Contracts\AttributeRepositoryPort;
use App\Attribute\Domain\Entities\Attributes;

class FindAttributeByIdService
{
    private AttributeRepositoryPort $attributeRepository;
    public function __construct(AttributeRepositoryPort $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }
    public function execute(string $id): Attributes
    {
        return $this->attributeRepository->findById($id);
    }
}
