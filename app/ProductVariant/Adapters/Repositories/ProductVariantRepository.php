<?php

namespace App\ProductVariant\Adapters\Repositories;
use App\Core\Repositories\BaseRepository;
use App\ProductVariant\Domain\Contracts\ProductVariantRepositoryPort;
use App\Models\ProductVariant as ProductVariantModel;
use App\ProductVariant\Domain\Entities\ProductVariant;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;


class ProductVariantRepository extends BaseRepository implements ProductVariantRepositoryPort
{
    public function __construct()
    {
        parent::__construct(ProductVariantModel::class);
    }
    public function getAll(int $perPage, array $filters = ['name'], array $sorts = ['name'], string $defaultSort = 'updated_at', array $with = []): LengthAwarePaginator
    {
        return parent::getAll($perPage, $filters, $sorts, $defaultSort, $with);
    }
    public function create(ProductVariant $productVariant): ProductVariant
    {
        $uniqueSku = $this->generateUniqueSku($productVariant->sku, $productVariant->product_id);

        $productVariantModel = ProductVariantModel::create([
            'product_id'   => $productVariant->product_id,
            'sku'          => $uniqueSku,
            'price'        => $productVariant->price,
            'cost_price'   => $productVariant->cost_price,
            'sale_price'   => $productVariant->sale_price,
            'is_active'    => $productVariant->is_active,
        ]);

        return new ProductVariant($productVariantModel->toArray());
    }

    public function reloadWithAttributes(string $variantId): ProductVariant
    {
        $productVariantModel = ProductVariantModel::with(['product', 'attributeValues.attribute','inventory', 'images'])
            ->findOrFail($variantId);

        $variantData = $productVariantModel->toArray();

        $variantData['attribute_values'] = collect($productVariantModel->attributeValues)->map(function ($attrVal) {
            return [
                'attribute_id'         => $attrVal->attribute->id ?? null,
                'attribute_name'       => $attrVal->attribute->name ?? null,
                'attribute_value_id'   => $attrVal->id,
                'attribute_value_name' => $attrVal->value,
            ];
        })->toArray();

        return new ProductVariant($variantData);
    }

    public function findById(string $id): ProductVariant
    {
        $productVariantModel = ProductVariantModel::with([
            'product',
            'attributeValues.attribute',
            'inventory',
            'images'
        ])->findOrFail($id);
    
        return new ProductVariant($productVariantModel->toArray());
    }
    
    public function getVariantsByProductId(string $productId): Collection
    {
        return ProductVariantModel::with([
            'attributeValues.attribute',
            'attributeValues.images',
            'inventory',
            'images',
        ])->where('product_id', $productId)->get();
    }

    private function generateUniqueSku(string $baseSku, string $productId): string
    {
        $suffix = substr($productId, -4);

        return $baseSku . '-' . strtoupper($suffix);
    }
    public function delete(string $id): void
    {
         ProductVariantModel::where('id', $id)->delete();
    }
}
