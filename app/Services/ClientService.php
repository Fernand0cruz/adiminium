<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ClientService
{
    public function getAllClients()
    {
        // Retorna todos os clientes paginados, com 20 clientes por página.
        return User::where('role', 'client')->paginate(20);
    }

    public function getClientById($id)
    {
        // Retorna o cliente com o ID fornecido.
        return User::findOrFail($id);
    }

    public function createClient(array $data)
    {
        // Adiciona o papel do usuário como 'client'
        $data['role'] = 'client';
        // Criptografa a senha antes de salvar no banco de dados
        $data['password'] = Hash::make($data['password']);

        // Cria um novo cliente com os dados fornecidos.
        return User::create($data);
    }

    public function updateClient($id, array $data)
    {
        // Recupera o cliente com o ID fornecido.
        $client = User::findOrFail($id);
        // Atualiza os dados do cliente com os novos dados fornecidos.
        $client->fill($data);
        // Atualiza a senha se um novo valor foi fornecido
        if (!empty($data['password'])) {
            // Criptografa a nova senha antes de salvar no banco de dados
            $client->password = Hash::make($data['password']);
        } else {
            // Remove a senha do array de dados se não houver uma nova senha
            unset($client->password);
        }
        // Salva o cliente atualizado no banco de dados.
        $client->save();

        // Retorna o cliente atualizado.
        return $client;
    }

    public function deleteClient($id)
    {
        // Recupera o cliente com o ID fornecido.
        $client = User::findOrFail($id);

        // Deleta o cliente do banco de dados.
        $client->delete();
    }
}
