<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Services\OrderService;
use App\Traits\HandlesExceptions;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    use HandlesExceptions;

    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        return $this->handleExceptions(function () {
            Log::info('Initiating fetch for all orders.');
            $orders = $this->orderService->getOrders();
            Log::info('Successfully fetched orders.', ['orders_count' => count($orders)]);
            return $this->success($orders, 'Orders fetched successfully.');
        });
    }

    public function store(OrderStoreRequest $request)
    {
        return $this->handleExceptions(function () use ($request) {
            Log::info('Initiating creation of a new order.', ['request_data' => $request->all()]);
            $validated = $request->validated();
            $order = $this->orderService->createOrder($validated);
            Log::info('Order created successfully.', ['order_id' => $order->id, 'order_data' => $order]);
            return $this->success($order, 'Order created successfully.', 201);
        }, 404, 'Product not found.');
    }

    public function update(OrderUpdateRequest $request, $id)
    {
        return $this->handleExceptions(function () use ($request, $id) {
            Log::info("Initiating update for order ID: {$id}.", ['request_data' => $request->all()]);
            $validated = $request->validated();
            $order = $this->orderService->updateOrder($id, $validated);

            $status = $validated['status'] ?? null;
            $message = 'Order updated successfully.';

            switch ($status) {
                case 'in progress':
                    $message = 'Order is now in progress.';
                    break;
                case 'cancelled':
                    $message = 'Order has been cancelled.';
                    break;
                case 'denied':
                    $message = 'Order has been denied.';
                    break;
                case 'accepted':
                    $message = 'Order has been accepted.';
                    break;
                default:
                    $message = 'Order updated successfully.';
                    break;
            }

            Log::info($message, ['order_id' => $order->id, 'status' => $status, 'updated_data' => $order]);
            return $this->success($order, $message);
        }, 404, 'Order not found.');
    }

    public function destroy($id)
    {
        return $this->handleExceptions(function () use ($id) {
            Log::info("Initiating deletion for order with ID: {$id}.");
            $this->orderService->deleteOrder($id);
            Log::info('Order deleted successfully.', ['order_id' => $id]);
            return $this->success([], 'Order deleted successfully.');
        }, 404, 'Order not found.');
    }

    public function ordersInProgress()
    {
        return $this->handleExceptions(function () {
            Log::info('Fetching orders in progress.');
            $orders = $this->orderService->getOrdersInProgress();
            Log::info('Successfully fetched orders in progress.', ['orders_count' => count($orders)]);
            return $this->success($orders, 'Orders in progress fetched successfully.');
        });
    }

    public function ordersCompleted()
    {
        return $this->handleExceptions(function () {
            Log::info('Fetching completed orders.');
            $orders = $this->orderService->getOrdersCompleted();
            Log::info('Successfully fetched completed orders.', ['orders_count' => count($orders)]);
            return $this->success($orders, 'Completed orders fetched successfully.');
        });
    }

    public function allOrdersInProgress()
    {
        return $this->handleExceptions(function () {
            Log::info('Fetching all orders in progress.');
            $orders = $this->orderService->getAllOrdersInProgress();
            Log::info('Successfully fetched all orders in progress.', ['orders_count' => count($orders)]);
            return $this->success($orders, 'All orders in progress fetched successfully.');
        });
    }

    public function allOrders()
    {
        return $this->handleExceptions(function () {
            Log::info('Fetching all orders.');
            $orders = $this->orderService->getAllOrders();
            Log::info('Successfully fetched all orders.', ['orders_count' => count($orders)]);
            return $this->success($orders, 'All orders fetched successfully.');
        });
    }
}
