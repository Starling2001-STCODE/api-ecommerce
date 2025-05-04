<?php

namespace App\ShippingAddress\Domain\Services;

use App\ShippingAddress\Domain\Contracts\ShippingAddressRepositoryPort;
use App\ShippingAddress\Domain\Entities\ShippingAddress;

class FindShippingAddressByUserIdService
{
    /**
     * Create a new class instance.
     */
    private ShippingAddressRepositoryPort $shippingAddressRepository;

    public function __construct(ShippingAddressRepositoryPort $shippingAddressRepository)
    {
        $this->shippingAddressRepository = $shippingAddressRepository;
    }

    /**
     * Retorna un array de ShippingAddress del usuario autenticado
     */
    public function execute(string $userId): array
    {
        return $this->shippingAddressRepository->findByUserId($userId);
    }
}
