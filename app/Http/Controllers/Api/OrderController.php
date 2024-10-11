<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PendingOrder;
use Illuminate\Http\Request;
use App\Models\Product;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        $order = Order::where('client_id', $validated['client_id'])
            ->where('product_id', $validated['product_id'])
            ->first();

        if ($order) {
            $newQuantity = $order->quantity + $validated['quantity'];

            if ($product->stock_quantity < $newQuantity) {
                return response()->json(['error' => 'Quantidade máxima já inserida no seu pedido.']);
            }

            $order->update(['quantity' => $newQuantity]);

            $order->update(['quantity' => $newQuantity]);
        } else {
            Order::create([
                'client_id' => $validated['client_id'],
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'status' => 'opened'
            ]);
        }

        return response()->json(['success' => 'Produto adicionado aos seus pedidos com sucesso!'], 200);
    }
    public function index()
    {
        //rever: apos autenticação da ap recuperar cliente para filtra pedidos por clientes
        $ordersOpen = Order::where('status', 'opened')->with('product')->get();
        //rever: relação para carregar user e produtos juntamente com as ordens pendentes para exibir ao admin do sistema
        $ordersPending = PendingOrder::where('status', 'pending')->get();

        return response()->json([
            'ordersOpen' => $ordersOpen,
            'ordersPending' => $ordersPending,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $order = Order::findOrFail($id);
        $order->quantity = $validated['quantity'];
        $order->save();

        return response()->json(['success' => 'Pedido atualizado com sucesso!'], 200);
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json(['success' => 'Pedido excluído com sucesso!'], 200);
    }

    public function sendOrderStore(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:users,id',
            'order_data' => 'required|array',
            'order_data.*.id' => 'required|integer|exists:products,id',
            'order_data.*.product_id' => 'required|integer|exists:products,id',
            'order_data.*.quantity' => 'required|integer|min:1',
            'status' => 'required|in:pending,accepted,denied',
        ]);

        PendingOrder::create([
            'client_id' => $validated['client_id'],
            'order_data' => json_encode($validated['order_data']),
            'status' => $validated['status'],
        ]);

        foreach ($validated['order_data'] as $order) {
            Order::where('id', $order['id'])->delete();
        }

        return response()->json(['success' => 'Pedido realizado com sucesso.']);
    }

    public function allOrderIndex()
    {
        $allOrders = PendingOrder::where('status', 'pending')->get();

        return response()->json([
            'allOrders' => $allOrders
        ]);
    }
}
