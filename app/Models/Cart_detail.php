<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart_detail extends BaseModel
{
    protected $fillable = [
        'quantity',
        'price_at_time',
        'cart_id',
        'product_id',
        'variant_id',
        'created_at',
        'updated_at',
    ];
    public function carts(){
        return $this->belongsTo(Cart::class);
    }
    public function products(){
        return $this->belongsTo(Product::class);
    }   
}
