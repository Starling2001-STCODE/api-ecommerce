<?php

namespace App\Cart\Adapters\Controllers;

use App\Cart\Domain\Services\CreateCartService;
use App\Cart\Domain\Services\MigrateGuestCartService;
use App\Cart\Domain\Services\FindCartByUserId;
use App\Cart\Http\Requests\CreateCartRequest;
use App\Cart\Http\Resources\CartResource;
use App\Core\Controllers\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;


class CartController extends BaseController
{
    protected CreateCartService $createCartService;
    protected MigrateGuestCartService $migrateGuestCartService;
    protected FindCartByUserId $findCartByUserId;

    public function __construct(
        CreateCartService $createCartService,
        MigrateGuestCartService $migrateGuestCartService,
        FindCartByUserId $findCartByUserId)
    {
        $this->createCartService = $createCartService;
        $this->migrateGuestCartService = $migrateGuestCartService;
        $this->findCartByUserId = $findCartByUserId;
    }
    public function index(Request $request)
    {
        // $perPage = $this->getPerPage($request);
        // $products = $this->listProductsService->execute($perPage);
        // return ProductResource::collection($products);
    }

    public function store(CreateCartRequest $request): JsonResponse
    {
        $data = $request->validated();
        $identifier = Auth::guard('sanctum')->check() ? Auth::guard('sanctum')->id() : guest_session();
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

        return (new CartResource($cart))
            ->response()
            ->setStatusCode(200);
    }

    public function migrateGuestCart(Request $request)
    {
        $user = Auth::guard('sanctum')->check()
        ? Auth::guard('sanctum')->id()
        : guest_session();
        if (!$user) {
            return response()->json(['message' => 'No autorizado'], 401);
        }
    
        $items = $request->input('items', []);
    
        $this->migrateGuestCartService->execute($items, $user);
    
        return response()->json(['message' => 'Carrito migrado exitosamente.']);
    }
    
}
