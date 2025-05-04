<?php

namespace App\Cart\Domain\Services;

use App\Cart\Domain\Contracts\CartRepositoryPort;
use Illuminate\Support\Facades\DB;
use App\Cart\Domain\Services\FindCartByUserId;
use App\Cart\Domain\Services\FindBySessionId;
use App\Cart\Domain\Services\ValidateCartItemsService; // 👈 Importante
use App\Cart\Domain\Entities\Cart;
use Illuminate\Support\Facades\Log;

class MigrateGuestCartService
{
    private CartRepositoryPort $cartRepository;
    private FindCartByUserId $findCartByUserId;
    private FindBySessionId $findBySessionId;
    private ValidateCartItemsService $validateCartItemsService;

    public function __construct(
        CartRepositoryPort $cartRepository,
        FindCartByUserId $findCartByUserId,
        FindBySessionId $findBySessionId,
        ValidateCartItemsService $validateCartItemsService // 👈 Inyectamos el servicio
    )
    {
        $this->cartRepository = $cartRepository;
        $this->findCartByUserId = $findCartByUserId;
        $this->findBySessionId = $findBySessionId;
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
            // 1. Validar los items antes de migrarlos
            $validatedItems = $this->validateCartItemsService->execute($items);

            // 2. Buscar carrito del usuario o crear uno nuevo
            try {
                $userCart = $this->findCartByUserId->execute($userId);
            } catch (\Exception $e) {
                $userCart = $this->cartRepository->create(new Cart([
                    'user_id' => $userId,
                    'status' => 'active',
                ]));
            }

            // 3. Insertar los items validados en el carrito
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
