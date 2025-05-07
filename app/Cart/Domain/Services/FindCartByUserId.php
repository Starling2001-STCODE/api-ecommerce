<?php

namespace App\Cart\Domain\Services;
use App\Cart\Domain\Contracts\CartRepositoryPort;
use App\Cart\Domain\Entities\Cart;
use Illuminate\Support\Facades\Auth;
class FindCartByUserId
{
    private CartRepositoryPort $cartRepository;
    public function __construct(
    CartRepositoryPort $cartRepository, 
    )
    {
        $this->cartRepository = $cartRepository;
    }
    public function execute(string $userId): Cart
    {
        try {
            return $this->cartRepository->findByUserId($userId);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                $user_idToCart = new Cart(['user_id' => $userId]); 
                $cart = $this->cartRepository->create($user_idToCart);
                return $cart;
        }
    }
}
