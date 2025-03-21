<?php

namespace App\Cart\Domain\Services;
use App\Cart\Domain\Contracts\CartRepositoryPort;
use App\CartDetail\Domain\Contracts\CartDetailRepositoryPort;
use App\CartDetail\Adapters\Repositories\CartDetailRepository;
use App\Cart\Domain\Services\FindCartByUserId;
use App\Cart\Domain\Services\findBySessionId;
use App\Cart\Domain\Entities\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Uid\Ulid;

class CreateCartService
{
    private CartRepositoryPort $cartRepository;
    private CartDetailRepositoryPort $cartDetailRepository;
    private FindCartByUserId $findCartByUserId;
    private findBySessionId $findBySessionId;
    public function __construct(
    CartRepositoryPort $cartRepository, 
    CartDetailRepository $cartDetailRepository,
    FindCartByUserId $findCartByUserId,
    findBySessionId $findBySessionId,
    )
    {
        $this->cartRepository = $cartRepository;
        $this->cartDetailRepository = $cartDetailRepository;
        $this->findCartByUserId = $findCartByUserId;
        $this->findBySessionId = $findBySessionId;
    }
    public function execute(array $data): Cart
    {
         
        DB::beginTransaction(); 
        try {

        $identifier = Auth::guard('sanctum')->check()
        ? Auth::guard('sanctum')->id()
        : guest_session();

        if (Auth::guard('sanctum')->check()) {
            $userId = $identifier;
            $cart = $this->findCartByUserId->execute($userId);
        } else {
            $cart = $this->findBySessionId->execute($identifier);
        }

        $groupedItems = collect($data['items'])
        ->groupBy('product_id')
        ->map(function ($groupedProducts, $product_id) {
            return [
                'product_id' => $product_id,
                'quantity' => $groupedProducts->sum('quantity'), // suma todas las cantidades
                'price_at_time' => $groupedProducts->last()['price_at_time'], // último precio
            ];
        })
        ->values();
        $cartDetails = [];

        foreach ($groupedItems as $item) {
            $cartDetail = $this->cartDetailRepository->updateOrCreate([
                'cart_id' => $cart->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price_at_time' => $item['price_at_time'],
                'updated_at' => now(),
            ]);

            $cartDetails[] = $cartDetail;
        }

        $cart->cart_details = collect($cartDetails);

        DB::commit(); 
        return $cart; 

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
