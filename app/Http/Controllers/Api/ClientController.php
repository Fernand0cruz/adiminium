<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientStoreRequest;
use App\Http\Requests\ClientUpdateRequest;
use App\Services\ClientService;
use Illuminate\Support\Facades\Log;
use App\Traits\HandlesExceptions;

class ClientController extends Controller
{
    use HandlesExceptions;

    protected $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    public function index()
    {
        return $this->handleExceptions(function () {
            Log::info('Initiating fetch for all clients.');
            $clients = $this->clientService->getAllClients();
            Log::info('Successfully fetched clients.', ['clients_count' => count($clients)]);
            return $this->success($clients, 'Clients fetched successfully.');
        });
    }

    public function show($id)
    {
        return $this->handleExceptions(function () use ($id) {
            Log::info("Initiating fetch for client with ID: {$id}.");
            $client = $this->clientService->getClientById($id);
            Log::info('Successfully fetched client.', ['client_id' => $client->id]);
            return $this->success($client, 'Client fetched successfully.');
        }, 404, 'Client not found.');
    }

    public function store(ClientStoreRequest $request)
    {
        return $this->handleExceptions(function () use ($request) {
            Log::info('Initiating client creation.', ['request_data' => $request->all()]);
            $validated = $request->validated();
            $client = $this->clientService->createClient($validated);
            Log::info('Client created successfully.', ['client_id' => $client->id, 'created_data' => $client]);
            return $this->success($client, 'Client created successfully.', 201);
        });
    }

    public function update(ClientUpdateRequest $request, $id)
    {
        return $this->handleExceptions(function () use ($request, $id) {
            Log::info("Initiating update for client with ID: {$id}.", ['request_data' => $request->all()]);
            $validated = $request->validated();
            $client = $this->clientService->updateClient($id, $validated);
            Log::info('Client updated successfully.', ['client_id' => $client->id, 'updated_data' => $client]);
            return $this->success($client, 'Client updated successfully.');
        }, 404, 'Client not found.');
    }

    public function destroy($id)
    {
        return $this->handleExceptions(function () use ($id) {
            Log::info("Initiating deletion for client with ID: {$id}.");
            $this->clientService->deleteClient($id);
            Log::info('Client deleted successfully.', ['client_id' => $id]);
            return $this->success([], 'Client deleted successfully.');
        }, 404, 'Client not found.');
    }
}
