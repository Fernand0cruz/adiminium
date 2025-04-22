<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Services\CompanyService;
use App\Services\FileUploadService;
use App\Services\FormRequestHandlerService;
use App\Traits\HasControllerActions;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\CompanyUpdateRequest;
use Illuminate\Http\UploadedFile;

class CompanyController extends Controller
{
    use HasControllerActions;

    protected CompanyRepositoryInterface $repository;
    protected CompanyService $companyService;
    protected FormRequestHandlerService $formRequestHandler;
    protected FileUploadService $fileUploadService;

    public function __construct(
        CompanyRepositoryInterface $repository,
        CompanyService             $companyService,
        FormRequestHandlerService  $formRequestHandler,
        FileUploadService          $fileUploadService
    )
    {
        $this->repository = $repository;
        $this->companyService = $companyService;
        $this->formRequestHandler = $formRequestHandler;
        $this->fileUploadService = $fileUploadService;
    }

    public function store(CompanyStoreRequest $request): JsonResponse
    {
        $validated = $this->formRequestHandler->getValidatedData($request);

        if (isset($validated['image']) && $validated['image'] instanceof UploadedFile) {
            $validated['image'] = $this->fileUploadService->upload($validated['image'], 'images');
        }

        return $this->storeItem($validated);
    }

    public function update(CompanyUpdateRequest $request, $id): JsonResponse
    {
        $validated = $this->formRequestHandler->getValidatedData($request);

        if (isset($validated['image']) && $validated['image'] instanceof UploadedFile) {
            $validated['image'] = $this->fileUploadService->upload($validated['image'], 'images');
        }

        return $this->updateItem($validated, $id);
    }

    public function findCompaniesWithoutUser(): JsonResponse
    {
        $companiesWithoutUser = $this->companyService->getCompaniesWithoutUser();

        return $this->successResponse($companiesWithoutUser);
    }
}
