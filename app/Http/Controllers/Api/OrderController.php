<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStoreRequest;
use App\Services\OrderService;
use App\Traits\HandlesExceptions;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    use HandlesExceptions;

    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function store(OrderStoreRequest $request): JsonResponse
    {
        return $this->handleExceptions(fn () =>
            $this->success($this->orderService->createOrder($request->validated()), 'Pedido criado com sucesso!', 201)
        );
    }

    public function index(): JsonResponse
    {
        return $this->handleExceptions(fn () =>
            $this->success($this->orderService->getOrderActive(),  'Pedido ativo carregado com sucesso!')
        );
    }
}
