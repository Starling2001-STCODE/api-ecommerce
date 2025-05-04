<?php

namespace App\ShippingAddress\Adapters\Controllers;

use App\Core\Controllers\BaseController;
use App\ShippingAddress\Domain\Services\CreateShippingAddressService;
use App\ShippingAddress\Domain\Services\FindShippingAddressByIdService;
use App\ShippingAddress\Domain\Services\UpdateShippingAddressService;
use App\ShippingAddress\Domain\Services\ListShippingAddressService;
use App\ShippingAddress\Domain\Services\DeleteShippingAddressService;
use App\ShippingAddress\Domain\Services\FindShippingAddressByUserIdService;
use App\ShippingAddress\Http\Requests\CreateShippingAddressRequest;
use App\ShippingAddress\Http\Resources\ShippingAddressResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class ShippingAddressController extends BaseController
{
    private CreateShippingAddressService $createShippingAddressService;
    private FindShippingAddressByIdService $findShippingAddressByIdService;
    private UpdateShippingAddressService $updateShippingAddressService;
    private ListShippingAddressService $listShippingAddressService;
    private DeleteShippingAddressService $deleteShippingAddressService;
    private FindShippingAddressByUserIdService $findShippingAddressByUserIdService;

    public function __construct(
        CreateShippingAddressService $createShippingAddressService,
        FindShippingAddressByIdService $findShippingAddressByIdService,
        UpdateShippingAddressService $updateShippingAddressService,
        ListShippingAddressService $listShippingAddressService,
        DeleteShippingAddressService $deleteShippingAddressService,
        FindShippingAddressByUserIdService $findShippingAddressByUserIdService,
    )
    {
        $this->createShippingAddressService = $createShippingAddressService;
        $this->findShippingAddressByIdService = $findShippingAddressByIdService;
        $this->updateShippingAddressService = $updateShippingAddressService;
        $this->listShippingAddressService = $listShippingAddressService;
        $this->deleteShippingAddressService = $deleteShippingAddressService;
        $this->findShippingAddressByUserIdService = $findShippingAddressByUserIdService;
    }

    public function index(Request $request)
    {
        $perPage = $this->getPerPage($request);
        $addresses = $this->listShippingAddressService->execute($perPage);
        return ShippingAddressResource::collection($addresses);
    }

    public function findByUserId(Request $request)
    {
        $userId = Auth::guard('sanctum')->user()->id;
        $addresses = $this->findShippingAddressByUserIdService->execute($userId);
        return ShippingAddressResource::collection($addresses);
    }

    public function store(CreateShippingAddressRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = Auth::guard('sanctum')->user()->id;
        $address = $this->createShippingAddressService->execute($data);
        return (new ShippingAddressResource($address))->response()->setStatusCode(201);
    }

    public function show(string $id): JsonResponse
    {
        $address = $this->findShippingAddressByIdService->execute($id);
        return (new ShippingAddressResource($address))->response()->setStatusCode(200);
    }

    public function update(CreateShippingAddressRequest $request, string $id): JsonResponse
    {
        $data = $request->validated();
        $address = $this->updateShippingAddressService->execute($id, $data);
        return (new ShippingAddressResource($address))->response()->setStatusCode(200);
    }

    public function destroy(string $id): JsonResponse
    {
        $this->deleteShippingAddressService->execute($id);
        return response()->json(null, 204);
    }
}
