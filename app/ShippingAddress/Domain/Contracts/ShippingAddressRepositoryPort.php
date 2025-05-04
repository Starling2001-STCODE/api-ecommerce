<?php

namespace App\ShippingAddress\Domain\Contracts;

use App\ShippingAddress\Domain\Entities\ShippingAddress;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ShippingAddressRepositoryPort
{
    public function create(ShippingAddress $shippingAddress): ShippingAddress;
    public function getAll(int $perPage): LengthAwarePaginator;
    public function findById(string $id): ShippingAddress;
    public function update(string $id, array $data): ShippingAddress;
    public function findByUserId(string $userId): array;
    public function delete(string $id): void;
}
