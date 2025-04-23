<?php

namespace App\AttributeValueImage\Adapters\Repositories;

use App\Core\Repositories\BaseRepository;
use App\AttributeValueImage\Domain\Contracts\AttributeValueImageRepositoryPort;
use App\Models\AttributeValueImage as AttributeValueImageModel;
use App\AttributeValueImage\Domain\Entities\AttributeValueImage;

class AttributeValueImageRepository extends BaseRepository implements AttributeValueImageRepositoryPort
{

    public function __construct()
    {
       parent::__construct(AttributeValueImageModel::class);
    }

    public function create(string $productId, string $attributeValueId, string $url, bool $isMain = false): AttributeValueImage
    {
        $AttributeValueImageModel = AttributeValueImageModel::create([
            'product_id' => $productId,
            'attribute_value_id' => $attributeValueId,
            'url' => $url,
            'is_main' => $isMain,
        ]);

        return new AttributeValueImage($AttributeValueImageModel->toArray());
    }
    public function getImagesByProductId(string $productId, ?string $attributeValueId = null): array
    {
        $query = AttributeValueImageModel::where('product_id', $productId);
    
        if ($attributeValueId) {
            $query->where('attribute_value_id', $attributeValueId);
        }
    
        return $query->get()
            ->map(fn($img) => new AttributeValueImage($img->toArray()))
            ->toArray();
    }
    
    public function findById(string $id): ?AttributeValueImage
    {
        $image = AttributeValueImageModel::find($id);

        return $image ? new AttributeValueImage($image->toArray()) : null;
    }
    public function delete(string $imageId): void
    {
        AttributeValueImageModel::where('id', $imageId)->delete();
    }
}
