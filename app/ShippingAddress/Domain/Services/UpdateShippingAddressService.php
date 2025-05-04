<?php

namespace App\ShippingAddress\Domain\Services;

use App\ShippingAddress\Domain\Contracts\ShippingAddressRepositoryPort;
use App\ShippingAddress\Domain\Entities\ShippingAddress;
use Illuminate\Support\Arr;

class UpdateShippingAddressService
{
    /**
     * Create a new class instance.
     */
    private ShippingAddressRepositoryPort $shippingAddressRepository;

    public function __construct(ShippingAddressRepositoryPort $shippingAddressRepository)
    {
        $this->shippingAddressRepository = $shippingAddressRepository;
    }

    public function execute(string $id, array $data): ShippingAddress
    {
        return $this->shippingAddressRepository->update($id, $data);
    }
}
