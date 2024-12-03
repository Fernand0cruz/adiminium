<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Services\ProductService;
use Illuminate\Support\Facades\Log;
use App\Traits\HandlesExceptions;

class ProductController extends Controller
{
    use HandlesExceptions;

    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        return $this->handleExceptions(function () {
            Log::info('Initiating product fetch process.');
            $products = $this->productService->getAllProducts();
            Log::info('Successfully fetched products.', ['products_count' => count($products)]);
            return $this->success($products, 'Products fetched successfully.');
        });
    }

    public function show($id)
    {
        return $this->handleExceptions(function () use ($id) {
            Log::info("Initiating fetch for product with ID: {$id}.");
            $product = $this->productService->getProductById($id);
            Log::info('Successfully fetched product.', ['product_id' => $product->id]);
            return $this->success($product, 'Product fetched successfully.');
        }, 404, 'Product not found.');
    }

    public function store(ProductStoreRequest $request)
    {
        return $this->handleExceptions(function () use ($request) {
            Log::info('Initiating product creation.', ['request_data' => $request->all()]);
            $validated = $request->validated();
            $product = $this->productService->createProduct($validated);
            Log::info('Product created successfully.', ['product_id' => $product->id, 'created_data' => $product]);
            return $this->success($product, 'Product created successfully.', 201);
        });
    }

    public function update(ProductUpdateRequest $request, $id)
    {
        return $this->handleExceptions(function () use ($request, $id) {
            Log::info("Initiating update for product with ID: {$id}.", ['request_data' => $request->all()]);
            $validated = $request->validated();
            $product = $this->productService->updateProduct($id, $validated);
            Log::info('Product updated successfully.', ['product_id' => $product->id, 'updated_data' => $product]);
            return $this->success($product, 'Product updated successfully.');
        }, 404, 'Product not found.');
    }

    public function destroy($id)
    {
        return $this->handleExceptions(function () use ($id) {
            Log::info("Initiating deletion for product with ID: {$id}.");
            $this->productService->deleteProduct($id);
            Log::info('Product deleted successfully.', ['product_id' => $id]);
            return $this->success([], 'Product deleted successfully.');
        }, 404, 'Product not found.');
    }
}
