<?php
namespace App\Size\Adapters\Controllers;

use App\Core\Controllers\BaseController;
use App\Size\Domain\Services\CreateSizeService;
use App\Size\Domain\Services\ListSizeServices;
use App\Size\Http\Requests\CreateSizeRequest;
use App\Size\Http\Resources\SizeResource;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SizeController extends BaseController
{
    private CreateSizeService $createSizeService;
    private ListSizeServices $listSizeServices;

    public function __construct(CreateSizeService $createSizeService, ListSizeServices $listSizeServices)
    {
        $this->createSizeService = $createSizeService;
        $this->listSizeServices = $listSizeServices;
    }
    public function index(Request $request)
    {
        $perPage = $this->getPerPage($request);
        $size = $this->listSizeServices->execute($perPage);
        return SizeResource::collection($size);
    }
    public function store(CreateSizeRequest $request): JsonResponse
    {
        $data = $request->validated();
        $size = $this->createSizeService->execute($data);
        return (new SizeResource($size))->response()->setStatusCode(201);
    }
}