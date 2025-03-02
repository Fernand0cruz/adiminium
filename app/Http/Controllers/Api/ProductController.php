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
            $this->success($this->productService->getProductById($id), 'Produto carregado com sucesso!')
        );
    }

    public function store(ProductStoreRequest $request): JsonResponse
    {
        return $this->handleExceptions(fn () => 
            $this->success($this->productService->createProduct($request->validated()), 'Produto criado com sucesso!', 201)
        );
    }

    public function update(ProductUpdateRequest $request, int $id): JsonResponse
    { 
        return $this->handleExceptions(fn () => 
            $this->success($this->productService->updateProduct($id, $request->validated()), 'Produto atualizado com sucesso!')
        );
    }

    public function destroy(int $id): JsonResponse
    {
        return $this->handleExceptions(fn () =>
            $this->success($this->productService->deleteProduct($id), 'Produto excluido com sucesso!')
        );
    }
}
