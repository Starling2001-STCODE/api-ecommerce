<?php

namespace App\ShippingAddress\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShippingAddressResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'type' => 'shipping-addresses',
            'id' => $this->id,
            'attributes' => [
                'user_id' => $this->user_id,
                'street_address' => $this->street_address,
                'house_number' => $this->house_number,
                'additional_info' => $this->additional_info,
                'city' => $this->city,
                'state' => $this->state,
                'postal_code' => $this->postal_code,
                'country' => $this->country,
                'lat' => $this->lat,
                'lng' => $this->lng,
                'email' => $this->email,
                'phone' => $this->phone,
                'line_address' => $this->line_address,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
        ];
    }
}
