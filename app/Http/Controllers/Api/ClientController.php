<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientStoreRequest;
use App\Http\Requests\ClientUpdateRequest;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Services\FormRequestHandlerService;
use App\Traits\HasControllerActions;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    use HasControllerActions;

    protected ClientRepositoryInterface $repository;
    protected FormRequestHandlerService $formRequestHandler;

    public function __construct(
        ClientRepositoryInterface $repository,
        FormRequestHandlerService $formRequestHandler
    )
    {
        $this->repository = $repository;
        $this->formRequestHandler = $formRequestHandler;
    }

    public function store(ClientStoreRequest $request): JsonResponse
    {
        $validated = $this->formRequestHandler->getValidatedData($request);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        return $this->storeItem($validated);
    }

    public function update(ClientUpdateRequest $request, int $id): JsonResponse
    {
        $validated = $this->formRequestHandler->getValidatedData($request);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        return $this->updateItem($validated, $id);
    }
}
