<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    protected OrderRepositoryInterface $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * @throws Exception
     */
    public function createOrder(array $data)
    {
        $order = $this->orderRepository->create([
            'company_id' => $data['company_id'],
            'total_price' => 0,
        ]);

        $this->addProductToOrder($order->id, $data);

        return $order;
    }

    public function getActiveOrderByCompany()
    {
        $companyId = Auth::user()?->company_id;
        return $this->orderRepository->findActiveWithRelations($companyId);
    }

    /**
     * @throws Exception
     */
    public function addProductToOrder(int $orderId, array $data)
    {
        $order = $this->orderRepository->find($orderId);
        if (!$order) {
            throw new Exception('Pedido não encontrado.');
        }

        $product = Product::findOrFail($data['products'][0]['product_id']);
        $quantity = $data['products'][0]['quantity'] ?? 1;

        $order->products()->attach($product->id, [
            'quantity' => $quantity,
            'price' => $product->price,
            'discount' => $product->discount,
        ]);

        $this->updateOrderTotal($order);

        return $order;
    }

    /**
     * @throws Exception
     */
    public function incrementProductQuantity(int $orderId, array $data)
    {
        return $this->modifyProductQuantity($orderId, $data, 'increment');
    }

    /**
     * @throws Exception
     */
    public function decrementProductQuantity(int $orderId, array $data)
    {
        return $this->modifyProductQuantity($orderId, $data, 'decrement');
    }

    /**
     * @throws Exception
     */
    public function removeProductFromOrder(int $orderId, array $data)
    {
        $order = $this->orderRepository->find($orderId);
        if (!$order) {
            throw new Exception('Pedido não encontrado.');
        }

        $productId = $data['products'][0]['product_id'];

        $order->products()->detach($productId);

        if ($order->products->isEmpty()) {
            $order->delete();
            return $order;
        }

        $this->updateOrderTotal($order);

        return $order;
    }

    /**
     * @throws Exception
     */
    private function modifyProductQuantity(int $orderId, array $data, string $operation)
    {
        $order = $this->orderRepository->find($orderId);
        if (!$order) {
            throw new Exception('Pedido não encontrado.');
        }

        $productId = $data['products'][0]['product_id'];
        $quantity = $data['products'][0]['quantity'] ?? 1;
        $product = Product::findOrFail($productId);

        $stock = $product->quantity;

        $pivotData = $order->products()->where('order_product.product_id', $productId)->first();
        if (!$pivotData) {
            throw new Exception('Produto não encontrado no pedido.');
        }

        $currentQuantity = $pivotData->pivot->quantity;
        $newQuantity = $operation === 'increment' ? $currentQuantity + $quantity : $currentQuantity - $quantity;

        if ($newQuantity > $stock) {
            throw new Exception('Quantidade excede o estoque disponível.');
        }

        if ($newQuantity <= 0) {
            $order->products()->detach($productId);
        } else {
            $order->products()->updateExistingPivot($productId, ['quantity' => $newQuantity]);
        }

        if ($order->products->isEmpty()) {
            $order->delete();
            return $order;
        }

        $this->updateOrderTotal($order);

        return $order;
    }

    private function calculateDiscountedPrice(Product $product): float
    {
        $unitPrice = $product->price;
        $discount = $product->discount;
        return $unitPrice - ($unitPrice * $discount / 100);
    }

    private function updateOrderTotal($order): void
    {
        $total = 0;

        foreach ($order->products as $product) {
            $discountedPrice = $this->calculateDiscountedPrice($product);
            $total += $discountedPrice * $product->pivot->quantity;
        }

        $order->total_price = $total;
        $order->save();
    }
}
