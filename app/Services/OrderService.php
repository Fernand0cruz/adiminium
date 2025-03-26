<?php

namespace App\Services;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class OrderService
{
    public function createOrder(array $data): Order
    {
        $totalPrice = 0;
        $orderProducts = [];

        foreach ($data['products'] as $item) {
            $product = Product::findOrFail($item['product_id']);
            $unitPrice = $product->price;
            $discount = $product->discount;

            $subtotal = $item['quantity'] * $unitPrice;

            $discountedPrice = $subtotal - ($subtotal * $discount / 100);

            $totalPrice += $discountedPrice;

            $orderProducts[$product->id] = [
                'quantity' => $item['quantity'],
                'discount' => $discount,
                'price' => $unitPrice,
            ];
        }

        $order = Order::create([
            'company_id' => $data['company_id'],
            'total_price' => $totalPrice,
        ]);

        $order->products()->attach($orderProducts);

        return $order->load('products');
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
