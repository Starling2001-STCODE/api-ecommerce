<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductVariant extends BaseModel
{
    protected $fillable = [
        'product_id',
        'sku',
        'price',
        'cost_price',
        'sale_price',
        'is_active',
    ];

    /**
     * Relación con el producto principal.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Valores de atributos asociados a esta variante.
     */
    public function attributeValues(): BelongsToMany
    {
        return $this->belongsToMany(AttributeValue::class, 'product_variant_attribute_value')
                    ->with('attribute')
                    ->withTimestamps();
    }

    /**
     * Relación uno a uno con inventario.
     */
    public function inventory(): HasOne
    {
        return $this->hasOne(Inventory::class);
    }

    /**
     * Relación uno a muchos con imágenes de la variante.
     */
    public function images(): HasMany
    {
        return $this->hasMany(VariantImage::class);
    }
    public function previewImages(): HasMany
    {
        return $this->hasMany(VariantImage::class)->limit(2);
    }
    
    /**
     * Relación muchos a muchos con transacciones de inventario.
     */
    public function transactions(): BelongsToMany
    {
        return $this->belongsToMany(InventoryTransaction::class, 'product_inventory_transaction')
                    ->withPivot('quantity', 'cost_price', 'sale_price')
                    ->withTimestamps();
    }
}