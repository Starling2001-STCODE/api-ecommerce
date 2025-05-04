<?php

namespace App\ShippingAddress\Domain\Services;

use App\ShippingAddress\Domain\Contracts\ShippingAddressRepositoryPort;
use App\ShippingAddress\Domain\Entities\ShippingAddress;

class CreateShippingAddressService
{
    /**
     * Create a new class instance.
     */
    private ShippingAddressRepositoryPort $shippingAddressRepository;

    public function __construct(ShippingAddressRepositoryPort $shippingAddressRepository)
    {
        $this->shippingAddressRepository = $shippingAddressRepository;
    }

    public function execute(array $data): ShippingAddress
    {
        $shippingAddress = new ShippingAddress($data);
        return $this->shippingAddressRepository->create($shippingAddress);
    }
}
