<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Services\OrderService;
use App\Traits\HasApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    use HasApiResponse;

    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function store(OrderStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $orderData = $this->orderService->createOrder($validated);

        return $this->successResponse($orderData,  'Created', 201);
    }

    public function show(): JsonResponse
    {
        $order = $this->orderService->getActiveOrderByCompany();

        return $order
            ? $this->successResponse($order)
            : $this->errorResponse('Item not found', 404);
    }

    /**
     * @throws Exception
     */
    public function addToOrder(OrderUpdateRequest $request, $id): JsonResponse
    {
        $validated = $request->validated();
        $updatedOrder = $this->orderService->addProductToOrder($id, $validated);

        return $updatedOrder
            ? $this->successResponse($updatedOrder, 'Updated')
            : $this->errorResponse('Item not found', 404);
    }

    public function incrementProduct(OrderUpdateRequest $request, $id): JsonResponse
    {
        $validated = $request->validated();
        $updatedOrder = $this->orderService->incrementProductQuantity($id, $validated);

        return $updatedOrder
            ? $this->successResponse($updatedOrder, 'Updated')
            : $this->errorResponse('Item not found', 404);
    }

    public function decrementProduct(OrderUpdateRequest $request, $id): JsonResponse
    {
        $validated = $request->validated();
        $updatedOrder = $this->orderService->decrementProductQuantity($id, $validated);

        return $updatedOrder
            ? $this->successResponse($updatedOrder, 'Updated')
            : $this->errorResponse('Item not found', 404);
    }

    /**
     * @throws Exception
     */
    public function removeProduct(OrderUpdateRequest $request, $id): JsonResponse
    {
        $validated = $request->validated();
        $updatedOrder = $this->orderService->removeProductFromOrder($id, $validated);

        return $updatedOrder
            ? $this->successResponse($updatedOrder, 'Updated')
            : $this->errorResponse('Item not found', 404);
    }
}
