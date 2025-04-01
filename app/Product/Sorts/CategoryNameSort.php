<?php

namespace App\Product\Sorts;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

class CategoryNameSort implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $query->join('categories', 'products.category_id', '=', 'categories.id')
              ->orderBy('categories.name', $descending ? 'desc' : 'asc')
              ->select('products.*'); 
    }
}