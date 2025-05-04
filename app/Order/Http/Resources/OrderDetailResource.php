<?php

namespace App\Order\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'display_order_id' => $this->display_order_id,
            'created_at' => $this->created_at,
            'expires_at' => $this->expires_at,
            'checkout_url' => $this->checkout_url,
            'total' => $this->total,
            'items' => $this->items,
        ];
    }
}
