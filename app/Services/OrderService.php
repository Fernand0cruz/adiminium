<?php

namespace App\Services;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Database\Eloquent\Collection;

class OrderService
{
    public function createOrder(array $data): Order
    {
        $order = Order::create([
            'company_id' => $data['company_id'],
        ]);

        $order->products()->attach($data['products']);

        return $order;
    }

    public function getOrderActive(): Collection
    {
        $user = auth()->user();

        return Order::with(['status', 'products'])
            ->where('company_id', $user->company_id)
            ->where('order_status_id', OrderStatus::getIdByStatus(OrderStatusEnum::ACTIVE))
            ->get();
    }
}
