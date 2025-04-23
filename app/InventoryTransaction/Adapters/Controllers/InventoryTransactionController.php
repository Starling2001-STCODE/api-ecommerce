<?php

namespace App\InventoryTransaction\Adapters\Controllers;

use App\Core\Controllers\BaseController;
// use App\InventoryTransaction\Domain\Services\AcceptTransferService;
// use App\InventoryTransaction\Domain\Services\CancelTransferService;
// use App\InventoryTransaction\Domain\Services\CreateAdjustmentService;
use App\InventoryTransaction\Http\Requests\CreatePurchaseRequest;
use App\InventoryTransaction\Domain\Services\CreatePurchaseService;
use App\InventoryTransaction\Domain\Services\FindInventoryTransactionByIdService;
// use App\InventoryTransaction\Domain\Services\CreateTransferService;
// use App\InventoryTransaction\Http\Requests\CreateAdjustmentRequest;
use App\InventoryTransaction\Http\Requests\CreateTransferRequest;
use App\InventoryTransaction\Http\Resources\InventoryTransactionResource;
use App\InventoryTransaction\Domain\Services\ListInventoryTransactionsService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Http\JsonResponse;


class InventoryTransactionController extends BaseController
{
    private FindInventoryTransactionByIdService $findInventoryTransactionByIdService;
    private CreatePurchaseService $createPurchaseService;
    // private CreateAdjustmentService $createAdjustmentService;
    // private CreateTransferService $createTransferService;
    // private CancelTransferService $cancelTransferService;
    // private AcceptTransferService $acceptTransferService;
    private ListInventoryTransactionsService $inventoryTransactionRepository;

    public function __construct(
        CreatePurchaseService $createPurchaseService,
        FindInventoryTransactionByIdService $findInventoryTransactionByIdService,
        // CreateAdjustmentService $createAdjustmentService,
        // CreateTransferService $createTransferService,
        // CancelTransferService $cancelTransferService,
        // AcceptTransferService $acceptTransferService,
        ListInventoryTransactionsService $inventoryTransactionRepository
    ) {
        $this->createPurchaseService = $createPurchaseService;
        $this->findInventoryTransactionByIdService = $findInventoryTransactionByIdService;
        // $this->createAdjustmentService = $createAdjustmentService;
        // $this->createTransferService = $createTransferService;
        // $this->cancelTransferService = $cancelTransferService;
        // $this->acceptTransferService = $acceptTransferService;
        $this->inventoryTransactionRepository = $inventoryTransactionRepository;
    }

    public function index(Request $request)
    {
        $perPage = $this->getPerPage($request);
        $reansactions = $this->inventoryTransactionRepository->execute($perPage);
        return InventoryTransactionResource::collection($reansactions);
    }
    public function createPurchase(CreatePurchaseRequest $request)
    {
        $data = $request->validated();
        $this->createPurchaseService->execute($data);
        return response()->json(null, 201);
    }
    public function showById(string $id)
    {
        $inventoryTransaction = $this->findInventoryTransactionByIdService->execute($id);
        return (new InventoryTransactionResource($inventoryTransaction))
            ->response()
            ->setStatusCode(200);
    }
    public function getByProductId(string $product_id): JsonResponse
    {
        $transactions = $this->findInventoryTransactionByIdService->getAllByProductId($product_id);

        return InventoryTransactionResource::collection($transactions)
            ->response()
            ->setStatusCode(200);
    }

    public function getByVariantId(string $variant_id): JsonResponse
    {
        $transactions = $this->findInventoryTransactionByIdService->getAllByProductVariantId($variant_id);

        return InventoryTransactionResource::collection($transactions)
            ->response()
            ->setStatusCode(200);
    }

    // public function createAdjustment(CreateAdjustmentRequest $request)
    // {
    //     $data = $request->validated();
    //     $this->createAdjustmentService->execute($data);
    //     return response()->json(null, 201);
    // }

    // public function createTransfer(CreateTransferRequest $request)
    // {
    //     $data = $request->validated();
    //     $this->createTransferService->execute($data);
    //     return response()->json(null, 201);
    // }

    // public function cancelTransfer(string $id)
    // {
    //     $this->cancelTransferService->execute($id);
    //     return response()->json(null, 204);
    // }

    // public function acceptTransfer(Request $request,  string $id)
    // {
    //     $this->acceptTransferService->execute($id, $request->user()->id);
    //     return response()->json(null, 204);
    // }
}
