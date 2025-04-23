<?php

namespace App\ProductVariant\Domain\Contracts;

use App\ProductVariant\Domain\Entities\ProductVariant;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ProductVariantRepositoryPort
{
    public function create(ProductVariant $product): ProductVariant;
    public function getAll(int $perPage): LengthAwarePaginator;
    public function findById(string $id): ProductVariant;
    public function reloadWithAttributes(string $variantId): ProductVariant;  
    public function getVariantsByProductId (string $productId): Collection;
    public function delete (string $id): void;
    // public function findManyByIds(array $ids): object;
}

