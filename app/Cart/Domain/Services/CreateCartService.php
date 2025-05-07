<?php

namespace App\Cart\Domain\Services;

use App\Cart\Domain\Contracts\CartRepositoryPort;
use App\CartDetail\Domain\Contracts\CartDetailRepositoryPort;
use App\Cart\Domain\Services\FindCartByUserId;
use App\Cart\Domain\Services\FindBySessionId;
use App\Cart\Domain\Services\ValidateCartItemsService;
use App\Cart\Domain\Entities\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateCartService
{
    private CartRepositoryPort $cartRepository;
    private CartDetailRepositoryPort $cartDetailRepository;
    private FindCartByUserId $findCartByUserId;
    private FindBySessionId $findBySessionId;
    private ValidateCartItemsService $validateCartItemsService;

    public function __construct(
        CartRepositoryPort $cartRepository, 
        CartDetailRepositoryPort $cartDetailRepository,
        FindCartByUserId $findCartByUserId,
        FindBySessionId $findBySessionId,
        ValidateCartItemsService $validateCartItemsService 
    ) {
        $this->cartRepository = $cartRepository;
        $this->cartDetailRepository = $cartDetailRepository;
        $this->findCartByUserId = $findCartByUserId;
        $this->findBySessionId = $findBySessionId;
        $this->validateCartItemsService = $validateCartItemsService;
    }

    public function execute(array $data): Cart
    {
        DB::beginTransaction(); 

        try {
            $identifier = Auth::guard('sanctum')->check()
                ? Auth::guard('sanctum')->id()
                : guest_session();

            $cart = Auth::guard('sanctum')->check()
                ? $this->findCartByUserId->execute($identifier)
                : $this->findBySessionId->execute($identifier);

            $validatedItems = $this->validateCartItemsService->execute($data['items']);

            $groupedItems = collect($validatedItems)
                ->groupBy('product_id')
                ->map(function ($groupedProducts, $product_id) {
                    return [
                        'product_id' => $product_id,
                        'quantity' => $groupedProducts->sum('quantity'), 
                        'price_at_time' => $groupedProducts->last()['price_at_time'],
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
