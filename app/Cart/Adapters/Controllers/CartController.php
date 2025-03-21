<?php

namespace App\Cart\Adapters\Controllers;

use App\Cart\Domain\Services\CreateCartService;
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

    public function __construct(CreateCartService $createCartService)
    {
        $this->createCartService = $createCartService;
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
    public function show(string $id)
    {
        // $product = $this->findProductByIdService->execute($id);
        // return (new ProductResource($product))
        //     ->response()
        //     ->setStatusCode(200);
    }
}
