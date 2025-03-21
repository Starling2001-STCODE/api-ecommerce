<?php

namespace App\Category\Adapters\Controllers;

use App\Core\Controllers\BaseController;
use App\Category\Domain\Services\CreateCategoryService;
use App\Category\Domain\Services\FindCategoryByIdService;
use App\Category\Domain\Services\UpdateCategoryService;
use App\Category\Domain\Services\FindCategoryNameService;
use App\Category\Domain\Services\ListCategoryService;
use App\Category\Http\Resources\CategoryResource;
use App\Category\Http\Requests\CreateCategoryRequest;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    private CreateCategoryService $createCategoryService;
    private FindCategoryByIdService $findCategoryByIdService;
    private UpdateCategoryService $updateCategoryService;
    private FindCategoryNameService $findCategoryNameService;
    private ListCategoryService $listCategoryService;
    public function __construct(
        CreateCategoryService $createCategoryService,
        FindCategoryByIdService $findCategoryByIdService,
        UpdateCategoryService $updateCategoryService,
        FindCategoryNameService $findCategoryNameService,
        ListCategoryService $listCategoryService,
    )
    {
        $this->createCategoryService = $createCategoryService;
        $this->findCategoryByIdService = $findCategoryByIdService;
        $this->updateCategoryService = $updateCategoryService;
        $this->findCategoryNameService = $findCategoryNameService;
        $this->listCategoryService = $listCategoryService;
    }
    public function index(Request $request)
    {
        $perPage = $this->getPerPage($request);
        $category = $this->listCategoryService->execute($perPage);
        return CategoryResource::collection($category);
    }
    public function store(CreateCategoryRequest $request): JsonResponse
    {
        $data = $request->validated();
        $category = $this->createCategoryService->execute($data);
        return (new CategoryResource($category))->response()->setStatusCode(201);
    }
    public function show($id): JsonResponse
    {
        $category = $this->findCategoryByIdService->execute($id);
        return (new CategoryResource($category))->response()->setStatusCode(201);
    }
}
