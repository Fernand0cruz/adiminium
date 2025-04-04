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
            $item = $data['products'][0];
            $product = Product::findOrFail($item['product_id']);
            $quantity = $data['quantity'] ?? 1;
    
            $discountedPrice = $this->calculateDiscountedPrice($product);
    
            $order = Order::create([
                'company_id' => $data['company_id'],
                'total_price' => $discountedPrice * $quantity,
            ]);
    
            $order->products()->attach([
                $product->id => [
                    'quantity' => $quantity,
                    'discount' => $product->discount,
                    'price' => $product->price,
                ],
            ]);
    
            return $order->load('products');
        }
    
        public function getOrderActive(): Collection
        {
            $user = Auth::user();
    
            return Order::with(['status', 'products'])
                ->where('company_id', $user->company_id)
                ->where('order_status_id', OrderStatus::getIdByStatus(OrderStatusEnum::ACTIVE))
                ->get();
        }
    
        public function updateOrder(int $id, array $data)
        {
            $order = Order::with('products')->findOrFail($id);
    
            if (isset($data['increment_product'])) {
                return $this->updateProductQuantity($order, $data['increment_product'], 'increment');
            }
    
            if (isset($data['add_product'])) {
                return $this->addProductToOrder($order, $data['add_product']);
            }
    
            if (isset($data['decrement_product'])) {
                return $this->updateProductQuantity($order, $data['decrement_product'], 'decrement');
            }
    
            if (isset($data['delete_product'])) {
                return $this->removeProductFromOrder($order, $data['delete_product']);
            }
    
            return 'Nenhuma ação realizada.';
        }
    
        private function calculateDiscountedPrice(Product $product): float
        {
            $unitPrice = $product->price;
            $discount = $product->discount;
            return $unitPrice - ($unitPrice * $discount / 100);
        }
    
        private function updateProductQuantity(Order $order, array $productData, string $action): string
        {
            $product = $order->products()->where('product_id', $productData['product_id'])->first();
            $quantityChange = $productData['quantity'];
    
            if (!$product) {
                return 'Produto não encontrado no pedido!';
            }
    
            $discountedPrice = $this->calculateDiscountedPrice($product);
    
            if ($action === 'increment') {
                return $this->incrementProductQuantity($order, $product, $quantityChange, $discountedPrice);
            }
    
            if ($action === 'decrement') {
                return $this->decrementProductQuantity($order, $product, $quantityChange, $discountedPrice);
            }
    
            return 'Ação desconhecida.';
        }
    
        private function incrementProductQuantity(Order $order, $product, int $quantity, float $discountedPrice): string
        {
            $quantityAvailable = $product->quantity <= $product->pivot->quantity;
    
            if ($quantityAvailable) {
                throw new \Exception('Quantidade disponível em estoque insuficiente!');
            }
    
            $order->products()->updateExistingPivot($product->id, [
                'quantity' => $product->pivot->quantity + $quantity
            ]);
    
            $order->total_price += $discountedPrice * $quantity;
            $order->save();
    
            return 'Quantidade do produto aumentada com sucesso!';
        }
    
        private function decrementProductQuantity(Order $order, $product, int $quantity, float $discountedPrice): string
        {
            if ($product->pivot->quantity > $quantity) {
                $order->total_price -= $discountedPrice * $quantity;
                $order->products()->updateExistingPivot($product->id, [
                    'quantity' => $product->pivot->quantity - $quantity
                ]);
                $order->save();
    
                return 'Quantidade do produto reduzida com sucesso!';
            } else {
                $order->products()->detach($product->id);
                $order->total_price -= $discountedPrice * $product->pivot->quantity;
    
                if ($order->products()->count() === 0) {
                    $order->delete();
                    return 'Pedido removido porque não há mais produtos.';
                }
    
                $order->save();
                return 'Produto removido do pedido!';
            }
        }
    
        private function addProductToOrder(Order $order, array $productData): string
        {
            $product = Product::findOrFail($productData['product_id']);
            $quantity = $productData['quantity'] ?? 1;
    
            $discountedPrice = $this->calculateDiscountedPrice($product);
    
            $order->products()->attach(
                $productData['product_id'],
                [
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'discount' => $product->discount
                ]
            );
    
            $order->total_price += $discountedPrice * $quantity;
            $order->save();
    
            return 'Produto adicionado ao pedido com sucesso!';
        }
    
        private function removeProductFromOrder(Order $order, array $productData): string
        {
            $product = $order->products()->where('product_id', $productData['product_id'])->first();
            if ($product) {
                $discountedPrice = $this->calculateDiscountedPrice($product);
    
                $order->total_price -= $discountedPrice * $product->pivot->quantity;
                $order->products()->detach($product->id);
    
                if ($order->products()->count() === 0) {
                    $order->delete();
                    return 'Pedido removido porque não há mais produtos.';
                }
    
                $order->save();
                return 'Produto removido do pedido!';
            }
    
            return 'Produto não encontrado no pedido!';
        }
}
