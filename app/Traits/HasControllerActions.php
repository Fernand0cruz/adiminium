<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait HasControllerActions
{
    use HasApiResponse;

    public function index(): JsonResponse
    {
        return $this->successResponse($this->repository->all());
    }

    public function show($id): JsonResponse
    {
        $item = $this->repository->find($id);
        return $item
            ? $this->successResponse($item)
            : $this->errorResponse('Item not found', 404);
    }

    public function storeItem(array $validated): JsonResponse
    {
        $item = $this->repository->create($validated);

        return $this->successResponse($item, 'Created', 201);
    }

    public function updateItem(array $validated, int $id): JsonResponse
    {
        $item = $this->repository->update($id, $validated);

        return $item
            ? $this->successResponse($item, 'Updated')
            : $this->errorResponse('Item not found', 404);
    }

    public function destroy(int $id): JsonResponse
    {
        return $this->repository->delete($id)
            ? $this->successResponse(null, 'Deleted')
            : $this->errorResponse('Item not found', 404);
    }
}
