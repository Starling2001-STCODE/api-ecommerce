<?php

namespace App\Inventory\Adapters\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Inventory\Domain\Contracts\InventoryRepositoryPort;
use App\Models\Inventory as InventoryModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\InventoryTransaction\Domain\Exceptions\InsufficientInventoryException;

class InventoryRepository extends BaseRepository implements InventoryRepositoryPort
{
    public function __construct()
    {
        parent::__construct(InventoryModel::class);
    }

    public function getAll(int $perPage, array $filters = [], array $sorts = [], string $defaultSort = 'updated_at', array $with = []): LengthAwarePaginator
    {
        return parent::getAll($perPage, $filters, $sorts, $defaultSort, $with);
    }

    public function insertMany(array $data): void
    {
        InventoryModel::insert($data);
    }

    public function setMinimumStock(int $minimumStock, string $id): void
    {
        $inventory = InventoryModel::findOrFail($id);
        $inventory->minimum_stock = $minimumStock;
        $inventory->save();
    }

    public function incrementStock(array $data): void
    {
        foreach ($data as $item) {
            InventoryModel::where(function ($query) use ($item) {
                if (!empty($item['product_variant_id'])) {
                    $query->where('product_variant_id', $item['product_variant_id']);
                } else {
                    $query->where('product_id', $item['product_id']);
                }
            })->increment('quantity', $item['quantity']);
        }
    }
    public function adjustStock(array $data): void
    {
        foreach ($data as $item) {
            InventoryModel::where(function ($query) use ($item) {
                if (!empty($item['product_variant_id'])) {
                    $query->where('product_variant_id', $item['product_variant_id']);
                } else {
                    $query->where('product_id', $item['product_id']);
                }
            })->update(['quantity' => $item['quantity']]);
        }
    }

    public function decrementStock(array $data): void
    {
        foreach ($data as $item) {
            $inventory = InventoryModel::where(function ($query) use ($item) {
                if (!empty($item['product_variant_id'])) {
                    $query->where('product_variant_id', $item['product_variant_id']);
                } else {
                    $query->where('product_id', $item['product_id']);
                }
            })->lockForUpdate()->first();
    
            if (!$inventory) {
                throw new ModelNotFoundException;
            }
    
            if ($inventory->quantity < $item['quantity']) {
                throw new InsufficientInventoryException;
            }
    
            $inventory->decrement('quantity', $item['quantity']);
        }
    }
}
