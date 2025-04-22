<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Services\FileUploadService;
use App\Services\FormRequestHandlerService;
use App\Traits\HasControllerActions;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;

class ProductController extends Controller
{
    use HasControllerActions;

    protected ProductRepositoryInterface $repository;
    protected FormRequestHandlerService $formRequestHandler;
    protected FileUploadService $fileUploadService;

    public function __construct(
        ProductRepositoryInterface $repository,
        FormRequestHandlerService  $formRequestHandler,
        FileUploadService $fileUploadService
    )
    {
        $this->repository = $repository;
        $this->formRequestHandler = $formRequestHandler;
        $this->fileUploadService = $fileUploadService;
    }

    public function store(ProductStoreRequest $request): JsonResponse
    {
        $validated = $this->formRequestHandler->getValidatedData($request);

        if (isset($validated['image']) && $validated['image'] instanceof UploadedFile) {
            $validated['image'] = $this->fileUploadService->upload($validated['image'], 'images');
        }

        return $this->storeItem($validated);
    }

    public function update(ProductUpdateRequest $request, $id): JsonResponse
    {
        $validated = $this->formRequestHandler->getValidatedData($request);

        if (isset($validated['image']) && $validated['image'] instanceof UploadedFile) {
            $validated['image'] = $this->fileUploadService->upload($validated['image'], 'images');
        }

        return $this->updateItem($validated, $id);
    }
}
