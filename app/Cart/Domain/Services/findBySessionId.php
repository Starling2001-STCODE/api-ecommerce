<?php

namespace App\Cart\Domain\Services;
use App\Cart\Domain\Contracts\CartRepositoryPort;
use App\Cart\Domain\Entities\Cart;
use Illuminate\Support\Facades\Auth;
class FindBySessionId
{
    private CartRepositoryPort $cartRepository;
    public function __construct(
    CartRepositoryPort $cartRepository, 
    )
    {
        $this->cartRepository = $cartRepository;
    }
    public function execute(string $session_id): Cart
    {
        try {
            // Intentamos obtener el carrito para el usuario
            return $this->cartRepository->findBySessionId( $session_id);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                $session_idToCart = new Cart(['session_id' => $session_id]); 
                $cart = $this->cartRepository->create($session_idToCart);
                return $cart;
        }
    }
}
