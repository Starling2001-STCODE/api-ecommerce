<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class InventoryTransaction extends BaseModel
{
    protected $fillable = [
        'user_id',
        'type',
        'ncf',
        'product_id',
        'product_variant_id',
        'invoice_number',
        'note',
    ];

    /**
     * Relación muchos a muchos con product_variants.
     * Esta relación también cubrirá productos simples, ya que el campo `product_variant_id` puede ser null.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(ProductVariant::class, 'product_inventory_transaction')
            ->withPivot('product_id', 'quantity', 'cost_price', 'sale_price')
            ->withTimestamps();
    }

    /**
     * Usuario que ejecutó la transacción.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
