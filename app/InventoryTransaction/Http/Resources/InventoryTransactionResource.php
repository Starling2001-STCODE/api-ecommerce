<?php

namespace App\InventoryTransaction\Http\Resources;

use App\User\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryTransactionResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "type" => "inventory-transactions",
            'attributes' => [
                'type' => $this->type,
                'note' => $this->note,
                'ncf' => $this->ncf,
                'invoiceNumber' => $this->invoice_number,
                'createdAt' => $this->created_at,
            ],
            'relationships' => [
                'user' => $this->user
                    ? new UserResource((object) $this->user)
                    : null,
                'products' => $this->products,
            ],
        ];
    }
}
