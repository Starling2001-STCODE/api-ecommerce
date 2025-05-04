<?php

namespace App\Order\Adapters\Controllers;

use App\Core\Controllers\BaseController;
use App\Order\Domain\Services\ListOrdersService;
use App\Order\Domain\Services\FindOrderByIdService;
use App\Order\Http\Resources\OrderResource;
use App\Order\Http\Resources\OrderDetailResource;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    private ListOrdersService $listOrdersService;
    private FindOrderByIdService $findOrderByIdService;

    public function __construct(
        ListOrdersService $listOrdersService,
        FindOrderByIdService $findOrderByIdService
    ) {
        $this->listOrdersService = $listOrdersService;
        $this->findOrderByIdService = $findOrderByIdService;
    }

    public function index(Request $request)
    {
        $orders = $this->listOrdersService->execute();
        return OrderResource::collection($orders);
    }

    public function show(string $id)
    {
        $order = $this->findOrderByIdService->execute($id);
        return new OrderDetailResource($order);
    }
}
