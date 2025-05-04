<?php

namespace App\Cart\Domain\Services;

use App\Cart\Domain\Services\FindCartByUserId;
use App\CartDetail\Domain\Contracts\CartDetailRepositoryPort;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateCartItemService
{
    protected FindCartByUserId $findCartByUserId;
    protected CartDetailRepositoryPort $cartDetailRepository;

    public function __construct(FindCartByUserId $findCartByUserId, CartDetailRepositoryPort $cartDetailRepository)
    {
        $this->findCartByUserId = $findCartByUserId;
        $this->cartDetailRepository = $cartDetailRepository;
    }

    public function execute(array $item): void
    {
        Log::info('UpdateCartItemService: ' . json_encode($item));
        Log::info('User ID: ' . Auth::guard('sanctum')->id());
        DB::beginTransaction();

        try {
            $userId = Auth::guard('sanctum')->id();
            $cart = $this->findCartByUserId->execute($userId);
            $this->cartDetailRepository->updateQuantityByProductAndVariant(
                $cart->id,
                $item['product_id'],
                $item['variant_id'] ?? null,
                $item['quantity']
            );

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

}
