<?php

namespace   App\InventoryTransaction\Filters;

use Spatie\QueryBuilder\Filters\Filter;

class TypeFilter implements Filter
{
    public function __invoke($query, $types, $property)
    {
        $types = is_array($types) ? $types : explode(',', $types);

        return $query->whereIn($property, $types);
    }
}
