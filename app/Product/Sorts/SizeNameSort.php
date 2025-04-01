<?php

namespace App\Product\Sorts;

use App\Models\Size;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

class SizeNameSort implements Sort
{
    public function __invoke(Builder $query, $descending, string $property)
    {
        $query->orderBy(
            Size::select('name')
                ->whereColumn('sizes.id', 'products.size_id'),
            $descending ? 'desc' : 'asc'
        );
    }
}
