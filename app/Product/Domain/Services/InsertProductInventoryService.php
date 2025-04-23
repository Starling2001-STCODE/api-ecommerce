<?php

namespace App\Product\Domain\Services;

use App\Product\Domain\Contracts\ProductRepositoryPort;
use App\Inventory\Adapters\Repositories\InventoryRepository;
use App\AttrCategory\Adapters\Repositories\AttrCategoryRepository;
use App\Product\Domain\Exceptions\ProductRequiresVariantsException;
use Symfony\Component\Uid\Ulid;
use LogicException;

class InsertProductInventoryService
{
    private ProductRepositoryPort $productRepository;
    private InventoryRepository $inventoryRepository;
    private AttrCategoryRepository $attrCategoryRepository;

    public function __construct(
        ProductRepositoryPort $productRepository,
        InventoryRepository $inventoryRepository,
        AttrCategoryRepository $attrCategoryRepository,
        )
    {
        $this->productRepository = $productRepository;
        $this->attrCategoryRepository = $attrCategoryRepository;
        $this->inventoryRepository = $inventoryRepository;
    }

    public function execute(string $productId, int $quantity, ?int $minimumStock = 0): void
    {
        $product = $this->productRepository->findById($productId);
        $requiresVariants = $this->attrCategoryRepository->catReqAttr($product->category_id);

        if ($requiresVariants) {
            throw new ProductRequiresVariantsException("Este producto requiere variantes para gestionar inventario.");
        }

        $this->inventoryRepository->insertMany([
            [
                'id' => Ulid::generate(),
                'product_id' => $productId,
                'product_variant_id' => null,
                'quantity' => $quantity,
                'minimum_stock' => $minimumStock,
            ]
        ]);
    }

}
