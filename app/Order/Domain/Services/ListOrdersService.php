<?php

namespace App\Order\Domain\Services;

use App\Order\Domain\Contracts\OrderRepositoryPort;
use App\Order\Domain\Entities\Order;
use Illuminate\Support\Facades\Auth;

class ListOrdersService
{
    private OrderRepositoryPort $orderRepository;

    public function __construct(OrderRepositoryPort $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function execute(): array
    {
        $userId = Auth::guard('sanctum')->id();
        return $this->orderRepository->findByUserId($userId);
    }
}
