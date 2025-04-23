<?php

namespace App\ProductImage\Adapters\Repositories;

use App\Core\Repositories\BaseRepository;
use App\ProductImage\Domain\Contracts\ProductImageRepositoryPort;
use App\Models\ProductImage as ProductImageModel;
use App\ProductImage\Domain\Entities\ProductImage;


class ProductImageRepository extends BaseRepository implements ProductImageRepositoryPort
{
    public function __construct()
    {
        parent::__construct(ProductImageModel::class);
    }

    public function create(string $productId, string $url, bool $isMain = false): ProductImage
    {
        $productImageModel = ProductImageModel::create([
            'product_id' => $productId,
            'url' => $url,
            'is_main' => $isMain,
        ]);

        return new ProductImage($productImageModel->toArray());
    }
    public function findByProductId(string $productId): array
    {
        return ProductImageModel::where('product_id', $productId)
            ->get()
            ->map(fn($img) => new ProductImage($img->toArray()))
            ->toArray();
    }
    public function findById(string $id): ?ProductImage
    {
        $image = ProductImageModel::find($id);

        return $image ? new ProductImage($image->toArray()) : null;
    }
    public function delete(string $imageId): void
    {
        ProductImageModel::where('id', $imageId)->delete();
    }
}
