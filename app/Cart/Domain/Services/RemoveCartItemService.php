<?php

namespace App\Cart\Domain\Services;

use App\Cart\Domain\Services\FindCartByUserId;
use App\CartDetail\Domain\Contracts\CartDetailRepositoryPort;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RemoveCartItemService
{
    protected FindCartByUserId $findCartByUserId;
    protected CartDetailRepositoryPort $cartDetailRepository;

    public function __construct(
        FindCartByUserId $findCartByUserId,
        CartDetailRepositoryPort $cartDetailRepository
    ) {
        $this->findCartByUserId = $findCartByUserId;
        $this->cartDetailRepository = $cartDetailRepository;
    }

    public function execute(array $itemData): void
    {
        DB::beginTransaction();

        try {
            $userId = Auth::guard('sanctum')->id();
            $cart = $this->findCartByUserId->execute($userId);

            $this->cartDetailRepository->deleteByProductAndVariant(
                $cart->id,
                $itemData['product_id'],
                $itemData['variant_id'] ?? null
            );
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

}
