<?php

namespace App\ProductImage\Domain\Contracts;

use App\ProductImage\Domain\Entities\ProductImage;

interface ProductImageRepositoryPort
{
    public function create(string $productId, string $url, bool $isMain = false): ProductImage;

    public function findByProductId(string $productId): array;

    public function delete(string $imageId): void;

    public function findById(string $id): ?ProductImage;
}