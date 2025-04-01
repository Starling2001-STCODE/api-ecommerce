<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttributeValue extends BaseModel
{
    protected $table = 'attribute_values';

    protected $fillable = [
        'attribute_id',
        'value',
    ];

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }
    // public function productVariants(): BelongsToMany
    // {
    //     return $this->belongsToMany(ProductVariant::class, 'product_variant_attribute_value')
    //                 ->withTimestamps();
    // }
}
