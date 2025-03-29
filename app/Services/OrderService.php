<?php

namespace App\Services;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    public function createOrder(array $data): Order
    {
//        criar so se n existir order

        $item = $data['products'][0];

        $product = Product::findOrFail($item['product_id']);
        $unitPrice = $product->price;
        $discount = $product->discount;
        $quantity = $data['quantity'] ?? 1;

        $discountedPrice = $unitPrice - ($unitPrice * $discount / 100);

        $order = Order::create([
            'company_id' => $data['company_id'],
            'total_price' => $discountedPrice,
        ]);

        $order->products()->attach([
            $product->id => [
                'quantity' => $quantity,
                'discount' => $discount,
                'price' => $unitPrice,
            ],
        ]);

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
