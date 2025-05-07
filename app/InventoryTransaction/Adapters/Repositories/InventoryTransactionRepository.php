<?php

namespace App\InventoryTransaction\Adapters\Repositories;

use App\Core\Repositories\BaseRepository;
use App\InventoryTransaction\Domain\Contracts\InventoryTransactionRepositoryPort;
use App\InventoryTransaction\Domain\Entities\InventoryTransaction;
use App\Models\InventoryTransaction as InventoryTransactionModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use App\InventoryTransaction\Filters\CreatedAtFilter;
use App\InventoryTransaction\Filters\TypeFilter;
use App\InventoryTransaction\Sorts\CreatedByNamesort;
use Illuminate\Support\Collection;

class InventoryTransactionRepository extends BaseRepository implements InventoryTransactionRepositoryPort
{
    public function __construct()
    {
        parent::__construct(InventoryTransactionModel::class);
    }

    public function getAll(
        int $perPage,
        array $filters = [],
        array $sorts = [],
        string $defaultSort = 'updated_at',
        array $with = ['user']
    ): LengthAwarePaginator {
        $filters = [
            AllowedFilter::custom('type', new TypeFilter),
            AllowedFilter::custom('created_at', new CreatedAtFilter),
        ];

        $sorts = [
            AllowedSort::field('type'),
            AllowedSort::field('created_at'),
            AllowedSort::custom('created_by_name', new CreatedByNamesort),
        ];

        return parent::getAll($perPage, $filters, $sorts, $defaultSort, $with);
    }

    public function createPurchase(InventoryTransaction $inventoryTransaction): void
    {
        $firstProduct = $inventoryTransaction->products[0] ?? null;

        $model = InventoryTransactionModel::create([
            'type' => $inventoryTransaction->type,
            'product_id' => $firstProduct['product_id'] ?? null,
            'product_variant_id' => $firstProduct['product_variant_id'] ?? null,
            'ncf' => $inventoryTransaction->ncf,
            'invoice_number' => $inventoryTransaction->invoice_number,
            'note' => $inventoryTransaction->note,
            'user_id' => $inventoryTransaction->user_id,
        ]);

        $model->products()->sync($inventoryTransaction->products);
    }

    public function createAdjustment(InventoryTransaction $inventoryTransaction): void
    {
        $firstProduct = $inventoryTransaction->products[0] ?? null;
        $model = InventoryTransactionModel::create([
            'type' => $inventoryTransaction->type,
            'note' => $inventoryTransaction->note,
            'product_id' => $firstProduct['product_id'] ?? null,
            'product_variant_id' => $firstProduct['product_variant_id'] ?? null,
            'user_id' => $inventoryTransaction->user_id,
        ]);

        $model->products()->sync($inventoryTransaction->products);
    }

    public function createSale(InventoryTransaction $inventoryTransaction): void
    {
        $firstProduct = $inventoryTransaction->products[0] ?? null;

        $model = InventoryTransactionModel::create([
            'type' => $inventoryTransaction->type,
            'note' => $inventoryTransaction->note,
            'product_id' => $firstProduct['product_id'] ?? null,
            'product_variant_id' => $firstProduct['product_variant_id'] ?? null,
            'user_id' => $inventoryTransaction->user_id,
        ]);

        $model->products()->sync($inventoryTransaction->products);
    }

    public function createReturn(InventoryTransaction $inventoryTransaction): void
    {
        $firstProduct = $inventoryTransaction->products[0] ?? null;

        $model = InventoryTransactionModel::create([
            'type' => $inventoryTransaction->type,
            'ncf' => $inventoryTransaction->ncf,
            'invoice_number' => $inventoryTransaction->invoice_number,
            'note' => $inventoryTransaction->note,
            'product_id' => $firstProduct['product_id'] ?? null,
            'product_variant_id' => $firstProduct['product_variant_id'] ?? null,
            'user_id' => $inventoryTransaction->user_id,
        ]);

        $model->products()->sync($inventoryTransaction->products);
    }

    public function findById(string $id): InventoryTransaction
    {
        $model = InventoryTransactionModel::with(['products', 'user'])->findOrFail($id)->toArray();

        return new InventoryTransaction($model);
    }

    public function getAllByProductId(string $product_id): Collection
    {
        $models = InventoryTransactionModel::with(['productsSimple', 'user'])
            ->where('product_id', $product_id)
            ->get();

        return $models->map(fn($model) => new InventoryTransaction([
            ...$model->toArray(),
            'products' => $model->productsSimple, 
            'user' => $model->user,
        ]));
    }

    
    public function getAllByProductVariantId(string $product_variant_id): Collection
    {
        $models = InventoryTransactionModel::with(['products', 'user'])
            ->where('product_variant_id', $product_variant_id)
            ->get();
    
        return $models->map(fn($model) => new InventoryTransaction([
            ...$model->toArray(),
            'user' => $model->user,
        ]));
    }
    
    public function delete(string $id): int
    {
        return InventoryTransactionModel::destroy($id);
    }
}
