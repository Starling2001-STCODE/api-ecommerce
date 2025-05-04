<?php

namespace App\Cart\Domain\Services;

use App\Cart\Domain\Contracts\CartRepositoryPort;
use Illuminate\Support\Facades\DB;
use App\Cart\Domain\Services\FindCartByUserId;
use App\Cart\Domain\Services\ValidateCartItemsService;
use App\Cart\Domain\Entities\Cart;

class MigrateGuestCartService
{
    private CartRepositoryPort $cartRepository;
    private FindCartByUserId $findCartByUserId;
    private ValidateCartItemsService $validateCartItemsService;

    public function __construct(
        CartRepositoryPort $cartRepository,
        FindCartByUserId $findCartByUserId,
        ValidateCartItemsService $validateCartItemsService 
    )
    {
        $this->cartRepository = $cartRepository;
        $this->findCartByUserId = $findCartByUserId;
        $this->validateCartItemsService = $validateCartItemsService;
    }

    public function execute(array $items, string $userId): void
    {
        DB::beginTransaction();

        try {
            if (empty($items)) {
                DB::commit();
                return;
            }
            $validatedItems = $this->validateCartItemsService->execute($items);

            try {
                $userCart = $this->findCartByUserId->execute($userId);
            } catch (\Exception $e) {
                $userCart = $this->cartRepository->create(new Cart([
                    'user_id' => $userId,
                    'status' => 'active',
                ]));
            }

            foreach ($validatedItems as $item) {
                $this->cartRepository->addOrUpdateCartItem($userCart->id, $item);
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
