<?php

namespace App\Services;

use App\Exceptions\MaxQuantityExceededException;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    public function createOrder(array $data)
    {
        // Recupera o ID do cliente que está fazendo o pedido.
        $clientId = $data['client_id'];

        // Inicializa um array para armazenar os produtos que o cliente deseja pedir.
        $products = [];

        // Itera sobre os produtos que o cliente deseja pedir.
        foreach ($data['products_data'] as $productData) {
            // Adiciona os dados do produto ao array de produtos.
            $products[] = [
                'product_id' => $productData['product_id'],
                'price' => $productData['price'],
                'quantity' => $productData['quantity'],
            ];
        }

        // Verifica se já existe um pedido "open" (aberto) para esse cliente.
        $existingOrder = Order::where('client_id', $clientId)
            ->where('status', 'open')
            // Retorna o primeiro pedido aberto, caso exista.
            ->first(); 

    // Se já existir um pedido aberto, atualiza o pedido com os novos produtos.
        if ($existingOrder) {
            // Recupera os produtos já existentes nesse pedido e decodifica o JSON para um array PHP.
            $existingProducts = json_decode($existingOrder->products_data, true) ?? [];
            $existingProductMap = [];

            // Cria um mapa dos produtos existentes no pedido, onde a chave é o 'product_id'.
            foreach ($existingProducts as $existingProduct) {
                $existingProductMap[$existingProduct['product_id']] = [
                    'quantity' => $existingProduct['quantity'],
                    'price' => $existingProduct['price']
                ];
            }

            // Itera sobre os novos produtos que o cliente deseja adicionar ao pedido.
            foreach ($products as $newProduct) {
                // Recupera o ID do produto.
                $productId = $newProduct['product_id'];
                // Se o produto já existir no pedido
                if (isset($existingProductMap[$productId])) {
                    // Atualiza a quantidade do produto no pedido.
                    $newQuantity = $existingProductMap[$productId]['quantity'] + $newProduct['quantity'];
                    // Verifica se a nova quantidade do produto excede a quantidade disponível em estoque.
                    $availableStock = Product::findOrFail($productId)->stock_quantity;
                    // Se a nova quantidade do produto exceder a quantidade disponível em estoque, lança uma exceção.
                    if ($newQuantity > $availableStock) {
                        throw new MaxQuantityExceededException();
                    }
                    // Atualiza a quantidade e o preço do produto no mapa.
                    $existingProductMap[$productId]['quantity'] = $newQuantity;
                    $existingProductMap[$productId]['price'] = $newProduct['price'];
                } else {
                    // Caso o produto não exista no pedido, adiciona o novo produto ao map.
                    $existingProductMap[$productId] = [
                        'quantity' => $newProduct['quantity'],
                        'price' => $newProduct['price']
                    ];
                }
            }

            // Prepara o array final de produtos atualizados para salvar no banco.
            $updatedProducts = [];

            // Itera sobre o mapa de produtos existentes e adiciona os produtos atualizados ao array final.
            foreach ($existingProductMap as $id => $product) {
                $updatedProducts[] = [
                    'product_id' => $id,
                    'quantity' => $product['quantity'],
                    'price' => $product['price']
                ];
            }

            // Atualiza os dados do pedido existente com os novos produtos.
            $existingOrder->products_data = json_encode($updatedProducts);
            // Salva o pedido existente.
            $existingOrder->save(); 

            // Retorna o pedido existente atualizado.
            return $existingOrder;
        } else {
            // Se não houver um pedido aberto para esse cliente, cria um novo pedido.
            $order = Order::create([
                'client_id' => $clientId,
                'products_data' => json_encode($products), // Converte os produtos em um JSON antes de salvar.
                'status' => 'open', // O status inicial do pedido é "open" (aberto).
            ]);

            // Retorna o novo pedido criado.
            return $order;
        }
    }

    public function getOrders()
    {
        // Busca todos os pedidos do cliente autenticado.
        return $this->getOrdersByStatus(['open']);
    }

    public function getOrdersInProgress()
    {
        // Busca todos os pedidos em andamento do cliente autenticado.
        return $this->getOrdersByStatus(['in progress']);
    }

    public function getOrdersCompleted()
    {
        // Busca todos os pedidos concluídos do cliente autenticado.
        return $this->getOrdersByStatus(['accepted', 'denied', 'cancelled']);
    }

    public function getAllOrders()
    {
        // Busca todos os pedidos exceto os pedidos abertos com os dados do cliente.
        return $this->getOrdersByStatus(['!= open'], true);
    }

    public function getAllOrdersInProgress()
    {
        // Busca todos os pedidos em andamento do cliente autenticado com os dados do cliente.
        return $this->getOrdersByStatus(['in progress'], true);
    }

    private function getOrdersByStatus(array $statuses, bool $withClients = false)
    {
        // Inicializa uma query para buscar os pedidos.
        $query = Order::query();

        if ($withClients) {
            // Se a flag $withClients for verdadeira, carrega os dados do cliente relacionado ao pedido.
            $query->with('client');
        } else {
            // Se a flag $withClients for falsa, filtra os pedidos pelo ID do cliente autenticado.
            $query->where('client_id', Auth::id());
        }

        // Verifica se o array de status contém apenas um status com um operador de comparação.
        if (count($statuses) === 1 && str_contains($statuses[0], '!=')) {
            // Se o array de status contiver apenas um status com um operador de comparação, divide o status e o operador.
            [$operator, $value] = explode(' ', $statuses[0], 2);
            // Filtra os pedidos pelo status e operador de comparação.
            $query->where('status', $operator, $value);
        } else {
            // Filtra os pedidos pelos status fornecidos.
            $query->whereIn('status', $statuses);
        }

        // Busca os pedidos.
        $orders = $query->get();

        // Busca os IDs dos produtos nos pedidos.
        $productIds = $orders->flatMap(fn($order) => json_decode($order->products_data, true))
            ->pluck('product_id')
            ->unique();

        // Busca os produtos pelos IDs.
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        // Mapeia os pedidos e adiciona os detalhes dos produtos e clientes.
        $orders->each(function ($order) use ($products, $withClients) {
            // Adiciona os detalhes dos produtos ao pedido.
            $order->products_data = collect(json_decode($order->products_data, true))
                // Mapeia os produtos 
                ->map(function ($product) use ($products) {
                    return [
                        'product_details' => $products[$product['product_id']] ?? null,
                        'quantity' => $product['quantity'],
                        'price' => $product['price'],
                    ];
                });

            if ($withClients) {
                // Adiciona os detalhes do cliente ao pedido.
                $order->client_details = $order->client;
            }
        });
        return $orders;
    }

    public function updateOrder($id, array $data)
    {
        // Busca o pedido pelo ID.
        $order = Order::findOrFail($id);

        // Verifica se o status do pedido foi alterado
        if (isset($data['status']) && $data['status'] !== $order->status) {
            // Se o status do pedido foi alterado para "in progress" e existem produtos no pedido
            if ($data['status'] === 'in progress' && isset($data['products_data'])) {
                // Itera sobre os produtos do pedido e atualiza a quantidade em estoque
                foreach ($data['products_data'] as $productData) {
                    // Busca o produto pelo ID e atualiza a quantidade em estoque
                    $product = Product::findOrFail($productData['product_id']);
                    // Subtrai a quantidade do pedido da quantidade em estoque
                    $product->stock_quantity -= $productData['quantity'];
                    // Salva o produto
                    $product->save();
                }
            }

            // Se o status do pedido foi alterado para "cancelled" ou "denied" e existem produtos no pedido
            if (in_array($data['status'], ['cancelled', 'denied']) && isset($order->products_data)) {
                // Decodifica os produtos do pedido de JSON para um array PHP
                $productsData = json_decode($order->products_data, true);
                // Itera sobre os produtos do pedido e atualiza a quantidade em estoque
                foreach ($productsData as $productData) {
                    // Busca o produto pelo ID e atualiza a quantidade em estoque
                    $product = Product::findOrFail($productData['product_id']);
                    // Adiciona a quantidade do pedido de volta à quantidade em estoque
                    $product->stock_quantity += $productData['quantity'];
                    // Salva o produto
                    $product->save();
                }
            }
        }

        // Checa se existem produtos no pedido
        if (isset($data['products_data'])) {
            // Converte os produtos em JSON antes de salvar
            $data['products_data'] = json_encode($data['products_data']);
        }

        // Atualiza os dados do pedido com os novos dados
        $order->fill($data);
        // Salva o pedido
        $order->save();

        // Retorna o pedido atualizado
        return $order;
    }

    public function deleteOrder($id)
    {
        // Busca o pedido pelo ID e deleta o pedido.
        $order = Order::findOrFail($id);
        // Deleta o pedido.
        $order->delete();
    }
}
