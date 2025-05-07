<?php
namespace App\Cart\Domain\Entities;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class Cart
{
    public $id;
    public $session_id;
    public $status;
    public $user_id;
    public $created_at;
    public $updated_at;
    public Collection $cart_details;

    public function __construct($data)
    {
        if ($data instanceof Model) {
            $this->id = $data->id;
            $this->session_id = $data->session_id;
            $this->status = $data->status;
            $this->user_id = $data->user_id;
            $this->created_at = $data->created_at;
            $this->updated_at = $data->updated_at;

            $this->cart_details = $data->relationLoaded('cart_details')
                ? $data->cart_details
                : collect([]);
        } else {
            $this->id = $data['id'] ?? null;
            $this->session_id = $data['session_id'] ?? null;
            $this->status = $data['status'] ?? null;
            $this->user_id = $data['user_id'] ?? null;
            $this->created_at = $data['created_at'] ?? null;
            $this->updated_at = $data['updated_at'] ?? null;
            $this->cart_details = collect($data['cart_details'] ?? []);
        }
    }
}
