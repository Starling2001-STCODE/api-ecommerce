<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart_detail extends Model
{
    protected $fillable = [
        'quantity',
        'price_at_time',
        'cart_id',
        'product_id',
    ];
    // Relación muchos a uno con Cart (un detalle pertenece a un carrito)
    public function cart(){
        return $this->belongsTo(Cart::class);
    }
    //Relacion muchos a uno con porducto(un detalle pertenece a un producto)
    public function product(){
        return $this->belongsTo(Product::class);
    }   
}
