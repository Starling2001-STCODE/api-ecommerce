<?php

namespace App\VariantImage\Adapters\Repositories;
use App\Core\Repositories\BaseRepository;
use App\VariantImage\Domain\Contracts\VariantImageRepositoryPort;
use App\Models\VariantImage as VariantImageModel;
use App\VariantImage\Domain\Entities\VariantImage;

class VariantImageRepository extends BaseRepository implements VariantImageRepositoryPort
{
    public function __construct()
    {
        parent::__construct(VariantImageModel::class);
    }

    public function create(string $variantId, string $url, bool $isMain = false): VariantImage
    {
        $variantImageModel = VariantImageModel::create([
            'product_variant_id' => $variantId,
            'url' => $url,
            'is_main' => $isMain,
        ]);

        return new VariantImage($variantImageModel->toArray());
    }
    public function findByVariantId(string $variantId): array
    {
        return VariantImageModel::where('product_variant_id', $variantId)
            ->get()
            ->map(fn($img) => new VariantImage($img->toArray()))
            ->toArray();
    }
    public function findById(string $id): ?VariantImage
    {
        $image = VariantImageModel::find($id);

        return $image ? new VariantImage($image->toArray()) : null;
    }
    public function delete(string $imageId): void
    {
        VariantImageModel::where('id', $imageId)->delete();
    }
}
