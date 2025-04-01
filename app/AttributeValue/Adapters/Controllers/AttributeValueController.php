<?php

namespace App\AttributeValue\Adapters\Controllers;

use App\Core\Controllers\BaseController;
use App\AttributeValue\Domain\Services\CreateAttributeValueService;
use App\AttributeValue\Domain\Services\ListAttributeValueService;
use App\AttributeValue\Domain\Services\FindAttributeValueByIdService;
use App\AttributeValue\Domain\Services\UpdateAttributeValueService;
use App\AttributeValue\Http\Requests\CreateAttributeValueRequest;
use App\AttributeValue\Http\Requests\UpdateAttributeValueRequest;
use App\AttributeValue\Http\Resources\AttributeValueResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AttributeValueController extends BaseController
{
    private CreateAttributeValueService $createAttributeValueService;
    private ListAttributeValueService $listAttributeValueService;
    private FindAttributeValueByIdService $findAttributeValueByIdService;
    private UpdateAttributeValueService $updateAttributeValueService;
    public function __construct(
        CreateAttributeValueService $createAttributeValueService,
        ListAttributeValueService $listAttributeValueService,
        FindAttributeValueByIdService $findAttributeValueByIdService,
        UpdateAttributeValueService $updateAttributeValueService,
        )
    {
       $this->createAttributeValueService = $createAttributeValueService;
       $this->listAttributeValueService = $listAttributeValueService;
       $this->findAttributeValueByIdService = $findAttributeValueByIdService;
       $this->updateAttributeValueService = $updateAttributeValueService;
    }
    public function index(Request $request)
    {
        $perPage = $this->getPerPage($request);
        $attributeValue = $this->listAttributeValueService->execute($perPage);
        return AttributeValueResource::collection($attributeValue);
    }
    public function store(CreateAttributeValueRequest $request): JsonResponse
    {
        $data = $request->validated();
        $attributeValue = $this->createAttributeValueService->execute($data);
        return (new AttributeValueResource($attributeValue))->response()->setStatusCode(201);
    }
    public function show(string $id): JsonResponse
    {
        $attributeValue = $this->findAttributeValueByIdService->execute($id);
        return (new AttributeValueResource($attributeValue))
            ->response()
            ->setStatusCode(200);
    }

    public function update(UpdateAttributeValueRequest $request, string $id)
    {
        $data = $request->validated();
        $attributeValue = $this->updateAttributeValueService->execute($id, $data);
        return (new AttributeValueResource($attributeValue))
            ->response()
            ->setStatusCode(200);
    }
}
