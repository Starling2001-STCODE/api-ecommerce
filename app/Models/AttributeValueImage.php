<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class AttributeValueImage extends BaseModel
{
    protected $table = 'attribute_value_images';

    protected $fillable = [
        'product_id',
        'attribute_value_id',
        'url',
        'is_main',
    ];

    public function attributeValue(): BelongsTo
    {
        return $this->belongsTo(AttributeValue::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}