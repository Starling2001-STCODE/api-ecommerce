<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class OrderItem extends BaseModel
{
    protected $fillable = [
        'id', 'order_id', 'product_id', 'variant_id', 'quantity', 'price_at_time'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
