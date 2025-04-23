<?php

namespace App\Product\Adapters\Controllers;

use App\Core\Controllers\BaseController; 
use App\Product\Domain\Services\FindProductByIdService;
use App\Product\Domain\Services\CreateProductService;
use App\Product\Domain\Services\ListProductsService;
use App\Product\Domain\Services\UpdateProductService;
use App\Product\Domain\Contracts\ProductRepositoryPort;
use App\Product\Http\Requests\CreateProductRequest;
use App\Product\Http\Requests\UpdateProductRequest;
use App\Product\Http\Requests\InventoryProductSimpleRequest;
use App\Product\Http\Resources\ProductResource;
use App\Product\Http\Resources\ProductDetailResource;
use App\Product\Domain\Services\InsertProductInventoryService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends BaseController
{
    private CreateProductService $createProductService;
    private FindProductByIdService $findProductByIdService;
    private ListProductsService $listProductsService;
    private UpdateProductService $updateProductService;
    private ProductRepositoryPort $productRepository;
    private InsertProductInventoryService $inventoryService;

    public function __construct(
        CreateProductService $createProductService,
        FindProductByIdService $findProductByIdService,
        ListProductsService $listProductsService,
        UpdateProductService $updateProductService,
        ProductRepositoryPort $productRepository,
        InsertProductInventoryService $inventoryService
        )
    {
        $this->createProductService = $createProductService;
        $this->findProductByIdService = $findProductByIdService;
        $this->listProductsService = $listProductsService;
        $this->updateProductService = $updateProductService;
        $this->productRepository = $productRepository;
        $this->inventoryService = $inventoryService;
    }
    public function index(Request $request)
    {
        $perPege = $this->getPerPage($request);
        $product = $this->listProductsService->execute($perPege);
        return ProductResource::collection($product);   
    }
    public function store(CreateProductRequest $request): JsonResponse
    {
        $data = $request->validated();
        $product = $this->createProductService->execute($data);
        return (new ProductResource($product))
            ->response()
            ->setStatusCode(201);
    }

    public function show(string $id): JsonResponse
    {
        $product = $this->findProductByIdService->execute($id, true);
        return (new ProductDetailResource($product))
            ->response()
            ->setStatusCode(200);
    }

    public function update(UpdateProductRequest $request, string $id)
    {
        $data = $request->validated();
        $product = $this->updateProductService->execute($id, $data);
        return (new ProductDetailResource($product))
            ->response()
            ->setStatusCode(200);
    }
    public function destroy(string $productId): JsonResponse
    {
        $this->productRepository->delete($productId);

        return response()->json([
            'message' => 'Producto desactivado correctamente.'
        ], 200);
    }
    public function restore(string $productId): JsonResponse
    {
        $this->productRepository->restore($productId);

        return response()->json([
            'message' => 'Producto reactivado correctamente.'
        ], 200);
    }
    public function storeSimpleInventory(InventoryProductSimpleRequest $request, string $product): JsonResponse
    {
        $data = $request->validated();

        $this->inventoryService->execute(
            productId: $product,
            quantity: $data['quantity'],
            minimumStock: $data['minimum_stock'] ?? 0
        );

        return response()->json([
            'message' => 'Inventario registrado correctamente para producto sin variantes.'
        ], 201);
    }
}
