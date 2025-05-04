<?php

namespace App\ShippingAddress\Domain\Services;

use App\ShippingAddress\Domain\Contracts\ShippingAddressRepositoryPort;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListShippingAddressService
{
    /**
     * Create a new class instance.
     */
    private ShippingAddressRepositoryPort $shippingAddressRepository;

    public function __construct(ShippingAddressRepositoryPort $shippingAddressRepository)
    {
        $this->shippingAddressRepository = $shippingAddressRepository;
    }

    public function execute(int $perPage): LengthAwarePaginator
    {
        return $this->shippingAddressRepository->getAll($perPage);
    }
}
