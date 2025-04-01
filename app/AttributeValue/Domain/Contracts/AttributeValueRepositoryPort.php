<?php

namespace App\AttributeValue\Domain\Contracts;

use App\AttributeValue\Domain\Entities\AttributeValue;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface AttributeValueRepositoryPort
{
    public function create(AttributeValue $product): AttributeValue;
    public function getAll(int $perPage): LengthAwarePaginator;
    public function findById(string $id): AttributeValue;
    public function update(string $id, array $data): AttributeValue;
}
