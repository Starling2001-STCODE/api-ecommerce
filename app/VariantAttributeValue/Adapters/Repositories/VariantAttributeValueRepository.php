<?php

namespace App\VariantAttributeValue\Adapters\Repositories;
use App\VariantAttributeValue\Domain\Contracts\VariantAttributeValueRepositoryPort;
use App\Core\Repositories\BaseRepository;
use App\Models\ProductVariantAttributeValue as VariantAttributeValuetModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Exceptions\DuplicateVariantException;

class VariantAttributeValueRepository extends BaseRepository implements VariantAttributeValueRepositoryPort
{
    public function __construct()
    {
        parent::__construct(VariantAttributeValuetModel::class);
    }
    public function getAll(int $perPage, array $filters = ['name'], array $sorts = ['name'], string $defaultSort = 'updated_at', array $with = []): LengthAwarePaginator
    {
        return parent::getAll($perPage, $filters, $sorts, $defaultSort, $with);
    }
    public function attach(string $variantId, string $attributeId, string $attributeValueId): void
    {
        VariantAttributeValuetModel::create([
            'product_variant_id' => $variantId,
            'attribute_id' => $attributeId,
            'attribute_value_id' => $attributeValueId,
        ]);
    }
    public function detachAll(string $variantId): void
    {
        VariantAttributeValuetModel::where('product_variant_id', $variantId)->delete();
    }
    public function getAttributeValuesOfVariant(string $variantId): array
    {
        return VariantAttributeValuetModel::where('product_variant_id', $variantId)
            ->pluck('attribute_value_id')
            ->toArray();
    }
    public function existsCombination(string $productId, array $attributeValueIds): bool
    {
        $variantIds = VariantAttributeValuetModel::whereHas('productVariant', function ($query) use ($productId) {
            $query->where('product_id', $productId);
        })->pluck('product_variant_id')->unique();
    
        foreach ($variantIds as $variantId) {
            $existing = $this->getAttributeValuesOfVariant($variantId);
            sort($existing);
            sort($attributeValueIds);
    
            if ($existing === $attributeValueIds) {
                return true;
            }
        }
    
        return false;
    }
}
