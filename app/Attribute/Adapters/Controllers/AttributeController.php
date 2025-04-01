<?php

namespace App\Attribute\Adapters\Controllers;

use App\Core\Controllers\BaseController;
use App\Attribute\Domain\Services\CreateAttributeService;
use App\Attribute\Domain\Services\FindAttributeByIdService;
use App\Attribute\Domain\Services\UpdateAttributeService;
use App\Attribute\Domain\Services\FindAttributeByNameService;
use App\Attribute\Domain\Services\ListAttributeService;
use App\Attribute\Http\Resources\AttributeResource;
use App\Attribute\Http\Requests\CreateAttributeRequest;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AttributeController extends BaseController
{
    private CreateAttributeService $createAttributeService;
    private FindAttributeByIdService $findAttributeByIdService;
    private UpdateAttributeService $updateAttributeService;
    private FindAttributeByNameService $findAttributeByNameService;
    private ListAttributeService $listAttributeService;
    public function __construct(
        CreateAttributeService $createAttributeService,
        FindAttributeByIdService $findAttributeByIdService,
        UpdateAttributeService $updateAttributeService,
        FindAttributeByNameService $findAttributeByNameService,
        ListAttributeService $listAttributeService,
    )
    {
        $this->createAttributeService = $createAttributeService;
        $this->findAttributeByIdService = $findAttributeByIdService;
        $this->updateAttributeService = $updateAttributeService;
        $this->findAttributeByNameService = $findAttributeByNameService;
        $this->listAttributeService = $listAttributeService;
    }
    public function index(Request $request)
    {
        $perPage = $this->getPerPage($request);
        $attribute = $this->listAttributeService->execute($perPage);
        return AttributeResource::collection($attribute);
    }
    public function store(CreateAttributeRequest $request): JsonResponse
    {
        $data = $request->validated();
        $attribute = $this->createAttributeService->execute($data);
        return (new AttributeResource($attribute))->response()->setStatusCode(201);
    }
    public function show($id): JsonResponse
    {
        $attribute = $this->findAttributeByIdService->execute($id);
        return (new AttributeResource($attribute))->response()->setStatusCode(201);
    }
}

