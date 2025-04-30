<?php

namespace App\ProductVariant\Domain\Services;
use App\ProductVariant\Domain\Entities\ProductVariant;
use App\ProductVariant\Domain\Contracts\ProductVariantRepositoryPort;
use App\Inventory\Adapters\Repositories\InventoryRepository;
use App\VariantAttributeValue\Domain\Contracts\VariantAttributeValueRepositoryPort;
use Illuminate\Support\Facades\DB;
use App\Exceptions\DuplicateVariantException;
use App\Models\AttributeValue;
use Symfony\Component\Uid\Ulid;

class CreateProductVariantService
{
    private ProductVariantRepositoryPort $productVariantRepository;
    private InventoryRepository $inventoryRepository;
    private VariantAttributeValueRepositoryPort $variantAttributeValueRepository;
    public function __construct(
        ProductVariantRepositoryPort $productVariantRepository,
            InventoryRepository $inventoryRepository,
        VariantAttributeValueRepositoryPort $variantAttributeValueRepository) 
        {
            $this->productVariantRepository = $productVariantRepository;
            $this->inventoryRepository = $inventoryRepository;
            $this->variantAttributeValueRepository = $variantAttributeValueRepository;
        }
        
        public function execute(string $productId, array $variantsData): array
        {
            $createdVariants = [];
        
            DB::transaction(function () use ($productId, $variantsData, &$createdVariants) {
                foreach ($variantsData as $variant) {
        
                    $attributeValueIds = collect($variant['attribute_values'])->pluck('attribute_value_id')->toArray();
        
                    if ($this->variantAttributeValueRepository->existsCombination($productId, $attributeValueIds)) {
                        $labels = AttributeValue::with('attribute')
                            ->whereIn('id', $attributeValueIds)
                            ->get()
                            ->map(fn ($val) => $val->attribute->name . ': ' . $val->value)
                            ->join(', ');
        
                        throw new DuplicateVariantException(
                            "Ya existe una variante con la combinación: [$labels]",
                            $attributeValueIds
                        );
                    }
        
                    $variantEntity = new ProductVariant([
                        'product_id'  => $productId,
                        'sku'         => $variant['sku'],
                        'price'       => $variant['price'],
                        'cost_price'  => $variant['cost_price'] ?? null,
                        'sale_price'  => $variant['price'] ?? null,
                        'is_active'   => $variant['is_active'] ?? true,
                    ]);
        
                    $createdVariant = $this->productVariantRepository->create($variantEntity);
        
                    foreach ($variant['attribute_values'] as $attr) {
                        $this->variantAttributeValueRepository->attach(
                            $createdVariant->id,
                            $attr['attribute_id'],
                            $attr['attribute_value_id']
                        );
                    }
        
                    $this->inventoryRepository->insertMany([
                        [
                            'id' => Ulid::generate(),
                            'product_variant_id' => $createdVariant->id,
                            'quantity' => $variant['quantity'] ?? 0,
                            'minimum_stock' => $variant['minimum_stock'] ?? 0,
                        ]
                    ]);
        
                    $createdVariant = $this->productVariantRepository->reloadWithAttributes($createdVariant->id);
        
                    $createdVariants[] = $createdVariant;
                }
            });
        
            return $createdVariants;
        }
        

}
