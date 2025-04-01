<?php

namespace App\Attribute\Domain\Services;

use App\Attribute\Domain\Contracts\AttributeRepositoryPort;
use App\Attribute\Domain\Entities\Attributes;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListAttributeService
{
    private AttributeRepositoryPort $attributeRepository;
    public function __construct(AttributeRepositoryPort $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }
    public function execute(int $perPage): LengthAwarePaginator
    {
        return $this->attributeRepository->getAll($perPage);
    }
}
