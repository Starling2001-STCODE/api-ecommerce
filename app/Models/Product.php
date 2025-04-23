<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Product extends BaseModel
{
    protected $fillable = [
        'name',
        'description',
        'cost_price',
        'sale_price',
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
        'img',
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
    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }
    public function inventory()
    {
        return $this->hasOne(Inventory::class)
            ->whereNull('product_variant_id');
    }
    
    public function previewVariant()
    {
        return $this->hasOne(ProductVariant::class)->with('previewImages');
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
    public function scopeSizeName($query, $search)
    {
        return $query->whereHas('size', function ($query) use ($search) {
            $query->where('name', 'like', "%$search%");
        });
    }
    public function scopeTagsAll($query, array $tags){
        return $query->whereRaw("tags @> ?", [json_encode($tags)]);
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function limitedImages(): HasMany
    {
        return $this->hasMany(ProductImage::class)->limit(3);
    }
    public function attributeValuePreviewImages()
    {
        return $this->hasManyThrough(
            \App\Models\AttributeValueImage::class,
            \App\Models\ProductVariant::class,
            'product_id', // Foreign key on ProductVariant
            'product_id', // Local key on AttributeValueImage (filtro por producto)
            'id',         // Local key on Product
            'product_id'  // Foreign key on AttributeValueImage
        )
        ->join('product_variant_attribute_value', 'attribute_value_images.attribute_value_id', '=', 'product_variant_attribute_value.attribute_value_id')
        ->select('attribute_value_images.*')
        ->distinct()
        ->limit(1);
    }
}
