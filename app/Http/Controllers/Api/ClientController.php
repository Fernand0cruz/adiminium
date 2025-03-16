<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientStoreRequest;
use App\Http\Requests\ClientUpdateRequest;
use App\Services\ClientService;
use App\Traits\HandlesExceptions;
use Illuminate\Http\JsonResponse;

class ClientController extends Controller
{
    use HandlesExceptions;

    private ClientService $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    public function store(ClientStoreRequest $request): JsonResponse
    {
        return $this->handleExceptions(fn () =>
            $this->success($this->clientService->createClient($request->validated()), 'Cliente criado com sucesso!', 201)
        );
    }

    public function index(): JsonResponse
    {
        return $this->handleExceptions(fn () => 
            $this->success($this->clientService->getAllClients(), 'Clientes carregados com sucesso!')
        );
    }

    public function show(int $id): JsonResponse
    {
        return $this->handleExceptions(fn () =>
            $this->success($this->clientService->getClientById($id), 'Cliente carregado com sucesso!')
        );
    }

    public function update(ClientUpdateRequest $request, int $id): JsonResponse
    {
        return $this->handleExceptions(fn ()  =>
            $this->success($this->clientService->updateClient($id, $request->validated()), 'Cliente atualizado com sucesso!')
        );
    }

    public function destroy(int $id): JsonResponse
    {
        return $this->handleExceptions(fn () =>
            $this->success($this->clientService->deleteClient($id), 'Cliente excluido com sucesso!')
        );
    }
}
