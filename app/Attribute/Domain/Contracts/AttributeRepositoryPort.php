<?php

namespace App\Attribute\Domain\Contracts;

use App\Attribute\Domain\Entities\Attributes;
use \Illuminate\Contracts\Pagination\LengthAwarePaginator;


interface AttributeRepositoryPort
{
    
    public function create(Attributes $attribute): Attributes;
    public function getAll(int $perPage): LengthAwarePaginator;
    public function findById(string $id): Attributes;
    public function update(string $id, array $data): Attributes;
    public function findByName(string $name): Attributes;
    
}