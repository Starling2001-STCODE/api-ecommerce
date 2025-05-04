<?php

namespace App\Cart\Adapters\Controllers;

use App\Cart\Domain\Services\CreateCartService;
use App\Cart\Domain\Services\MigrateGuestCartService;
use App\Cart\Domain\Services\FindCartByUserId;
use App\Cart\Domain\Services\AddItemToCartService;
use App\Cart\Domain\Services\RemoveCartItemService;
use App\Cart\Domain\Services\UpdateCartItemService;
use App\Cart\Http\Requests\CreateCartRequest;
use App\Cart\Http\Requests\RemoveCartItemRequest;
use App\Cart\Http\Requests\UpdateCartItemRequest;
use App\Cart\Http\Requests\AddCartItemRequest;
use App\Cart\Http\Resources\CartResource;
use App\Core\Controllers\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends BaseController
{
    protected CreateCartService $createCartService;
    protected MigrateGuestCartService $migrateGuestCartService;
    protected FindCartByUserId $findCartByUserId;
    protected AddItemToCartService $addItemToCartService;
    protected RemoveCartItemService $removeCartItemService;
    protected UpdateCartItemService $updateCartItemService;

    public function __construct(
        CreateCartService $createCartService,
        MigrateGuestCartService $migrateGuestCartService,
        FindCartByUserId $findCartByUserId,
        AddItemToCartService $addItemToCartService,
        RemoveCartItemService $removeCartItemService,
        UpdateCartItemService $updateCartItemService
    ) {
        $this->createCartService = $createCartService;
        $this->migrateGuestCartService = $migrateGuestCartService;
        $this->findCartByUserId = $findCartByUserId;
        $this->addItemToCartService = $addItemToCartService;
        $this->removeCartItemService = $removeCartItemService;
        $this->updateCartItemService = $updateCartItemService;
    }

    public function store(CreateCartRequest $request): JsonResponse
    {
        $data = $request->validated();
        $cart = $this->createCartService->execute($data);

        return (new CartResource($cart))->response()->setStatusCode(201);
    }

    public function show()
    {
        $user = Auth::guard('sanctum')->user();

        if (!$user) {
            return response()->json(['message' => 'No autorizado'], 401);
        }

        $cart = $this->findCartByUserId->execute($user->id);

        return (new CartResource($cart))->response()->setStatusCode(200);
    }

    public function migrateGuestCart(Request $request)
    {
        $user = Auth::guard('sanctum')->id() ?? guest_session();

        if (!$user) {
            return response()->json(['message' => 'No autorizado'], 401);
        }

        $items = $request->input('items', []);

        $this->migrateGuestCartService->execute($items, $user);

        return response()->json(['message' => 'Carrito migrado exitosamente.']);
    }

    public function addItem(AddCartItemRequest $request)
    {
        $itemData = $request->only(['product_id', 'variant_id', 'quantity', 'price_at_time']);
        $cart = $this->addItemToCartService->execute($itemData);
        return (new CartResource($cart))->response()->setStatusCode(201);
    }

    public function updateItem(UpdateCartItemRequest $request)
    {
        $itemData = $request->only(['product_id', 'variant_id', 'quantity']);
        $this->updateCartItemService->execute($itemData);
        return response()->json(['message' => 'Cantidad actualizada']);
    }

    public function removeItem(RemoveCartItemRequest $request)
    {
        $itemData = $request->only(['product_id', 'variant_id']);
        $this->removeCartItemService->execute($itemData);
        return response()->json(['message' => 'Item eliminado del carrito']);
    }
}
