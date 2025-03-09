<?php

namespace App\Http\Controllers\Api;

use App\Services\CompanyService;
use App\Traits\HandlesExceptions;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\CompanyUpdateRequest;

class CompanyController extends Controller
{
    use HandlesExceptions;

    private CompanyService $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    public function index(): JsonResponse
    {
        return $this->handleExceptions(fn () => 
            $this->success($this->companyService->getAllCompanies(), 'Empresas carregadas com sucesso!')
        );
    }

    public function store(CompanyStoreRequest $request): JsonResponse
    {
        return $this->handleExceptions(fn () => 
            $this->success($this->companyService->createCompany($request->validated()), 'Empresa criada com sucesso!', 201)
        );
    }

    public function show(int $id): JsonResponse
    {
        return $this->handleExceptions(fn () => 
            $this->success($this->companyService->getCompanyById($id), 'Produto carregado com sucesso!')
        );
    }

    public function update(CompanyUpdateRequest $request, int $id): JsonResponse
    { 
        return $this->handleExceptions(fn () => 
            $this->success($this->companyService->updateCompany($id, $request->validated()), 'Empresa atualizada com sucesso!')
        );
    }

    public function destroy(int $id): JsonResponse
    {
        return $this->handleExceptions(fn () =>
            $this->success($this->companyService->deleteCompany($id), 'Empresa excluida com sucesso!')
        );
    }
}
