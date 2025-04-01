<?php

namespace App\Attribute\Domain\Services;

use App\Attribute\Domain\Contracts\AttributeRepositoryPort;
use App\Attribute\Domain\Entities\Attributes;


class CreateAttributeService
{
    private AttributeRepositoryPort $attributeRepository;
    public function __construct(AttributeRepositoryPort $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }
    public function execute(array $data): Attributes
    {
        $attribute = new Attributes($data);
        return $this->attributeRepository->create($attribute);
    }
}   
