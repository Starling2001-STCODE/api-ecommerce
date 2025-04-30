<?php

namespace App\Order\Domain\Contracts;

use App\Order\Domain\Entities\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface OrderRepositoryPort
{
    public function create(Order $order): Order;
    public function findById(string $id): Order;
    public function findBySessionId(string $sessionId): Order;
    public function findByUserId(string $userId): array;
    public function getAll(int $perPage): LengthAwarePaginator;
    public function update(string $id, array $data): Order;
    public function delete(string $id): void;
}