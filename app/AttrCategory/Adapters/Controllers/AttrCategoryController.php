<?php

namespace App\AttrCategory\Adapters\Controllers;
use App\Core\Controllers\BaseController;
use App\AttrCategory\Domain\Services\CreateAttrCategoryService;
use App\AttrCategory\Domain\Services\ListAttrCategoryService;
use App\AttrCategory\Domain\Services\FindAttrCategoryByIdService;
use App\AttrCategory\Domain\Services\UpdateAttrCategoryService;
use App\AttrCategory\Http\Requests\CreateAttrCategoryRequest;
// use App\AttrCategory\Http\Requests\UpdateAttrCategoryRequest;
use App\AttrCategory\Http\Resources\AttrCategoryResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class AttrCategoryController extends BaseController
{
    private CreateAttrCategoryService $createAttrCategoryService;
    private ListAttrCategoryService $listAttrCategoryService;
    private FindAttrCategoryByIdService $findAttrCategoryByIdService;
    private UpdateAttrCategoryService $updateAttrCategoryService;
    public function __construct(
        CreateAttrCategoryService $createAttrCategoryService,
        ListAttrCategoryService $listAttrCategoryService,
        FindAttrCategoryByIdService $findAttrCategoryByIdService,
        UpdateAttrCategoryService $updateAttrCategoryService,
        )
    {
       $this->createAttrCategoryService = $createAttrCategoryService;
       $this->listAttrCategoryService = $listAttrCategoryService;
       $this->findAttrCategoryByIdService = $findAttrCategoryByIdService;
       $this->updateAttrCategoryService = $updateAttrCategoryService;
    }
    public function index(Request $request)
    {
        $perPage = $this->getPerPage($request);
        $AttrCategory = $this->listAttrCategoryService->execute($perPage);
        return AttrCategoryResource::collection($AttrCategory);
    }
    public function store(CreateAttrCategoryRequest $request): JsonResponse
    {
        $data = $request->validated();
        $AttrCategory = $this->createAttrCategoryService->execute($data);
        return (new AttrCategoryResource($AttrCategory))->response()->setStatusCode(201);
    }
    public function show(string $id): JsonResponse
    {
        $AttrCategory = $this->findAttrCategoryByIdService->execute($id);
        return (new AttrCategoryResource($AttrCategory))
            ->response()
            ->setStatusCode(200);
    }

    // public function update(UpdateAttrCategoryRequest $request, string $id)
    // {
    //     $data = $request->validated();
    //     $AttrCategory = $this->updateAttrCategoryService->execute($id, $data);
    //     return (new AttrCategoryResource($AttrCategory))
    //         ->response()
    //         ->setStatusCode(200);
    // }
}
