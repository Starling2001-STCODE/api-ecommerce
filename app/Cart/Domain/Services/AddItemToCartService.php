<?php

namespace App\Cart\Domain\Services;

use App\Cart\Domain\Services\FindCartByUserId;
use App\CartDetail\Domain\Contracts\CartDetailRepositoryPort;
use App\Cart\Domain\Services\ValidateCartItemsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Cart\Domain\Entities\Cart;
use Illuminate\Support\Facades\Log;
class AddItemToCartService
{
    protected FindCartByUserId $findCartByUserId;
    protected CartDetailRepositoryPort $cartDetailRepository;
    protected ValidateCartItemsService $validateCartItemsService;

    public function __construct(
        FindCartByUserId $findCartByUserId,
        CartDetailRepositoryPort $cartDetailRepository,
        ValidateCartItemsService $validateCartItemsService
    ) {
        $this->findCartByUserId = $findCartByUserId;
        $this->cartDetailRepository = $cartDetailRepository;
        $this->validateCartItemsService = $validateCartItemsService;
    }

    public function execute(array $itemData): Cart
    {
        DB::beginTransaction();

        try {
            $userId = Auth::guard('sanctum')->id();
            $cart = $this->findCartByUserId->execute($userId);
            $this->cartDetailRepository->addOrUpdateByProductAndVariant($cart->id, $itemData);

            DB::commit();
            return $cart;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
