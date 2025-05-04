<?php

namespace App\ShippingAddress\Adapters\Repositories;

use App\ShippingAddress\Domain\Contracts\ShippingAddressRepositoryPort;
use App\ShippingAddress\Domain\Entities\ShippingAddress;
use App\Core\Repositories\BaseRepository;
use App\Models\ShippingAddress as ShippingAddressModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ShippingAddressRepository extends BaseRepository implements ShippingAddressRepositoryPort
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        parent::__construct(ShippingAddressModel::class);
    }

    public function getAll(int $perPage, array $filters = ['city', 'state', 'country'], array $sorts = ['updated_at'], string $defaultSort = 'updated_at', array $with = []): LengthAwarePaginator
    {
        return parent::getAll($perPage, $filters, $sorts, $defaultSort, $with);
    }

    public function create(ShippingAddress $shippingAddress): ShippingAddress
    {
        $addressModel = ShippingAddressModel::create([
            'user_id' => $shippingAddress->user_id,
            'street_address' => $shippingAddress->street_address,
            'house_number' => $shippingAddress->house_number,
            'additional_info' => $shippingAddress->additional_info,
            'city' => $shippingAddress->city,
            'state' => $shippingAddress->state,
            'postal_code' => $shippingAddress->postal_code,
            'country' => $shippingAddress->country,
            'lat' => $shippingAddress->lat,
            'lng' => $shippingAddress->lng,
            'email' => $shippingAddress->email,
            'phone' => $shippingAddress->phone,
            'line_address' => $shippingAddress->line_address,
        ]);

        return new ShippingAddress($addressModel->toArray());
    }

    public function findById(string $id): ShippingAddress
    {
        $addressModel = ShippingAddressModel::findOrFail($id);
        return new ShippingAddress($addressModel->toArray());
    }

    public function update(string $id, array $data): ShippingAddress
    {
        $addressModel = ShippingAddressModel::findOrFail($id);
        $addressModel->update($data);
        return new ShippingAddress($addressModel->toArray());
    }

    public function findByUserId(string $userId): array
    {
        $addresses = ShippingAddressModel::where('user_id', $userId)->get();
        return $addresses->map(fn($item) => new ShippingAddress($item->toArray()))->toArray();
    }
    public function delete(string $id): void
    {
        $addressModel = ShippingAddressModel::findOrFail($id);
        $addressModel->delete();
    }
}
