<?php

namespace App\AttributeValue\Domain\Services;

use App\AttributeValue\Domain\Contracts\AttributeValueRepositoryPort;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListAttributeValueService
{
    private AttributeValueRepositoryPort $attributeValueRepository;
    public function __construct(AttributeValueRepositoryPort $attributeValueRepository)
    {
        $this->attributeValueRepository = $attributeValueRepository;
    }
    public function execute(string $perPage): LengthAwarePaginator
    {
        return $this->attributeValueRepository->getAll($perPage);
    }
}
