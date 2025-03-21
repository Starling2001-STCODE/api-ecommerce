<?php

namespace App\Cart\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
use App\CartDetail\Http\Resources\CartDetailResource;
use Illuminate\Http\Request;


class CartResource extends JsonResource
{
    /**
     * Create a new class instance.
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'carts',
            'cart_id' => $this->id,
            'attributes' => [
                'session_id' => $this->session_id,
                'status' => $this->status,
                 'user_id' => $this->user_id,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            'relationships' => [
                'cart_details' => CartDetailResource::collection($this->cart_details),
            ],
        ];
    }
}
