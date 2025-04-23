<?php

namespace App\Models;


class Inventory extends BaseModel
{
    protected $fillable = [
        'product_id',
        'product_variant_id',
        'quantity',
        'minimum_stock',
    ];

    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
