<?php

namespace App\InventoryTransaction\Filters;

use Illuminate\Support\Facades\Log;
use Spatie\QueryBuilder\Filters\Filter;

class CreatedAtFilter implements Filter
{
    public function __invoke($query, $createdAt, $property)
    {
        if (is_string($createdAt)) {
            return $query->whereDate('created_at', $createdAt);
        }
        $from = $createdAt[0];
        $to = \Carbon\Carbon::parse($createdAt[1])->endOfDay();

        return $query->whereBetween('created_at', [$from, $to]);
    }
}
