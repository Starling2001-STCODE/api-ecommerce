<?php

namespace App\AttributeValueImage\Domain\Contracts;
use App\AttributeValueImage\Domain\Entities\AttributeValueImage;


interface AttributeValueImageRepositoryPort
{
    public function create(string $productId, string $attributeValueId, string $url, bool $isMain = false): AttributeValueImage;

    public function getImagesByProductId(string $productId, ?string $attributeValueId = null): array;

    public function delete(string $imageId): void;

    public function findById(string $id): ?AttributeValueImage;
}
