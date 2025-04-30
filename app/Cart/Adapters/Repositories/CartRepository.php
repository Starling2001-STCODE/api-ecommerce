<?php

namespace App\Cart\Adapters\Repositories;
use App\Cart\Domain\Entities\Cart;
use App\Models\Cart as cartModel;
use App\Core\Repositories\BaseRepository;
use App\Cart\Domain\Contracts\CartRepositoryPort;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Symfony\Component\Uid\Ulid;


class CartRepository extends BaseRepository implements CartRepositoryPort
{

    public function __construct()
    {
        parent::__construct(cartModel::class);
    }
    public function getAll(int $perPage, array $filters = ['name'], array $sorts = ['name'], string $defaultSort = 'updated_at', array $with = []): LengthAwarePaginator
    {
        return parent::getAll($perPage, $filters, $sorts, $defaultSort, $with);
    }
    public function create(Cart $cart): Cart
    {
        $cartModel = cartModel::create([
            'user_id' => $cart->user_id,
            'session_id' => $cart->user_id ? null : $cart->session_id,
            'status' => 'active',
        ]);
        $cartModel->load(['cart_details','users']);

        return new Cart($cartModel->toArray()); 
    }
    public function findById(string $id): Cart
    {
        $cartModel = cartModel::with(['cart_details', 'users'])->findOrFail($id);
        return new Cart($cartModel->toArray()); 
    }
    public function findByUserId(string $user_id): Cart
    {
        $cartModel = cartModel::with(['cart_details', 'users'])->where(['user_id' => $user_id])->firstOrFail();
        return new Cart($cartModel); 
    }
    public function findBySessionId(string $session_id): Cart
    {
        $cartModel = cartModel::with(['cart_details', 'users'])->where(['session_id' => $session_id])->firstOrFail();
        return new Cart($cartModel); 
    }

    public function update(string $id, array $data): Cart
    {
        $cartModel = cartModel::findOrFail($id);
        $cartModel->update($data);
        return new Cart($cartModel->toArray()); 
    }
    public function addOrUpdateCartItem(string $cartId, $guestItem): void
    {
        $cartModel = $this->model::findOrFail($cartId);

        $existingItem = $cartModel->cart_details()
            ->where('product_id', $guestItem['product_id'])
            ->first();

        if ($existingItem) {
            $existingItem->update([
                'quantity' => $existingItem->quantity + $guestItem['quantity'],
            ]);
        } else {
            $cartModel->cart_details()->create([
                'product_id' => $guestItem['product_id'],
                'variant_id' => $guestItem['variant_id'] ?? null,
                'quantity' => $guestItem['quantity'],
                'price_at_time' => $guestItem['price_at_time'],
            ]);
        }
    }
    public function delete(string $id): void
    {
        $cartModel = cartModel::findOrFail($id);
        $cartModel->delete();
    }

}
