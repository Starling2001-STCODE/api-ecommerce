<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'cost_price',
        'sale_price',
        'sku',
        'brand',
        'weight',
        'dimensions',
        'status',
        'featured',
        'rating_average',
        'tags',
        'category_id',
        'size_id',
        'user_id',
    ];
    protected $casts = [
        'id' => 'string', // ULID se maneja como string
        'cost_price' => 'decimal:2', // Decimal con 2 decimales para el precio de costo
        'sale_price' => 'decimal:2', // Decimal con 2 decimales para el precio de venta
        'weight' => 'decimal:2', // Decimal con 2 decimales para el peso
        'rating_average' => 'decimal:2', // Decimal con 2 decimales para la calificación promedio
        'featured' => 'boolean', // Campo booleano para el producto destacado
        'tags' => 'array', // Los tags son un campo JSON, así que se convierte en un array
        'category_id' => 'string', // ULID se maneja como string
        'size_id' => 'string', // ULID se maneja como string
        'user_id' => 'string', // ULID se maneja como string
        'status' => 'string', // El estado es un string con valores 'active' e 'inactive'
    ];
    public function user(){
        return $this->belongsTo(User::class); // (one to many)
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function size(){
        return $this->belongsTo(Size::class);
    }
    public function cart_detail(){
        return $this->hasMany(Cart_detail::class);
    }
    public function scopeName($query, $search)
    {
        return $query->where('name', 'like', "%$search%");
    }
    public function scopeCategoryName($query, $search)
    {
        return $query->whereHas('category', function ($query) use ($search) {
            $query->where('name', 'like', "%$search%");
            Log::info($query->toSql());
        });
    }
    public function scopeTagsAll($query, array $tags){
        return $query->whereRaw("tags @> ?", [json_encode($tags)]);
    }

}
