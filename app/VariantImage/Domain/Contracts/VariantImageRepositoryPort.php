<?php

namespace App\VariantImage\Domain\Contracts;
use App\VariantImage\Domain\Entities\VariantImage;

interface VariantImageRepositoryPort
{
    public function create(string $variantId, string $url, bool $isMain = false): VariantImage;

    public function findByVariantId(string $variantId): array;

    public function delete(string $imageId): void;

    public function findById(string $id): ?VariantImage;
}
