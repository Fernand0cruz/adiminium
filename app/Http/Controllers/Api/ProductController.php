<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Services\ProductService;
use App\Traits\HandlesExceptions;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    use HandlesExceptions;

    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(): JsonResponse
    {
        return $this->handleExceptions(fn () => 
            $this->success($this->productService->getAllProducts(), 'Produtos carregados com sucesso!')
        );
    }

    public function show(int $id): JsonResponse
    {
        return $this->handleExceptions(fn () => 
            $this->success($this->productService->getProductById($id), 'Product fetched successfully.')
        );
    }

    public function store(ProductStoreRequest $request): JsonResponse
    {
        return $this->handleExceptions(fn () => 
            $this->success($this->productService->createProduct($request->validated()), 'Product created successfully.', 201)
        );
    }

    public function update(ProductUpdateRequest $request, int $id): JsonResponse
    {
        return $this->handleExceptions(fn () => 
            $this->success($this->productService->updateProduct($id, $request->validated()), 'Product updated successfully.')
        );
    }

    public function destroy(int $id): JsonResponse
    {
        return $this->handleExceptions(fn () =>
            $this->success($this->productService->deleteProduct($id), 'Product deleted successfully.')
        );
    }
}
