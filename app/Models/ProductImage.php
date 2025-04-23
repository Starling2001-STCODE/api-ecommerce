<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends BaseModel
{
    protected $table = 'product_images';

    protected $fillable = [
        'product_id',
        'url',
        'is_main',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
