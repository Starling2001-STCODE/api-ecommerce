<?php

namespace App\InventoryTransaction\Sorts;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

class CreatedByNamesort implements Sort
{
    public function __invoke(Builder $query, $descending, string $property)
    {
        $query->orderBy(
            User::select('name')
                ->whereColumn('users.id', 'inventory_transactions.user_id'),
            $descending ? 'desc' : 'asc'
        );
    }
}
