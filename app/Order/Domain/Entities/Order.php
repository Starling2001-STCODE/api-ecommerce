<?php
namespace App\Order\Domain\Entities;

class Order
{
    public ?string $id;
    public ?string $display_order_id;
    public ?string $user_id;
    public string $status;
    public ?string $session_id;
    public ?string $checkout_url;
    public ?string $expires_at;
    public float $total;
    public ?string $created_at;
    public ?string $updated_at;
    public array $items = [];

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->display_order_id = $data['display_order_id'] ?? null;
        $this->user_id = $data['user_id'] ?? null;
        $this->status = $data['status'] ?? 'pending_payment';
        $this->session_id = $data['session_id'] ?? null;
        $this->checkout_url = $data['checkout_url'] ?? null;
        $this->expires_at = $data['expires_at'] ?? null;
        $this->total = $data['total'] ?? 0.0;
        $this->created_at = $data['created_at'] ?? null;
        $this->updated_at = $data['updated_at'] ?? null;
        $this->items = $data['items'] ?? [];
    }
}
