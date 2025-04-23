<?php

namespace App\VariantAttributeValue\Domain\Contracts;

interface VariantAttributeValueRepositoryPort
{
    public function attach(string $variantId, string $attributeId, string $attributeValueId): void;
    public function detachAll(string $variantId): void;
    public function getAttributeValuesOfVariant(string $variantId): array;
    public function existsCombination(string $productId, array $attributeValueIds): bool;

}