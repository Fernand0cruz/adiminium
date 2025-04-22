<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Models\OrderStatus;
use App\Enums\OrderStatusEnum;

class OrderRepository implements OrderRepositoryInterface
{
    public function all()
    {
        return Order::paginate(15);
    }

    public function find($id)
    {
        return Order::find($id);
    }

    public function create(array $data)
    {
        return Order::create($data);
    }

    public function update($id, array $data)
    {
        $order = Order::find($id);
        if (!$order)
            return null;

        $order->update($data);
        return $order;
    }

    public function delete($id)
    {
        $order = Order::find($id);
        if (!$order)
            return false;

        return $order->delete();
    }

    public function findActiveWithRelations($companyId)
    {
        return Order::with(['status', 'products'])
            ->where('company_id', $companyId)
            ->where('order_status_id', OrderStatus::getIdByStatus(OrderStatusEnum::ACTIVE))
            ->first();
    }
}
