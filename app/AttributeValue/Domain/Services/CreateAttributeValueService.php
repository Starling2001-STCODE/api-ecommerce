<?php

namespace App\AttributeValue\Domain\Services;

use App\AttributeValue\Domain\Contracts\AttributeValueRepositoryPort;
use App\AttributeValue\Domain\Entities\AttributeValue;
use Illuminate\Support\Facades\DB;

class CreateAttributeValueService
{
    private AttributeValueRepositoryPort $attributeValueRepository;
    public function __construct(AttributeValueRepositoryPort $attributeValueRepository)
    {
        $this->attributeValueRepository = $attributeValueRepository;
    }
    public function execute(array $data): AttributeValue
    {
        return DB::transaction(function () use ($data) {
            $attributeValueEntity = new AttributeValue($data);
            $attributeValue =  $this->attributeValueRepository->create($attributeValueEntity);
            return $attributeValue;
        });
    }

}
