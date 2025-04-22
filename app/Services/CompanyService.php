<?php

namespace App\Services;


use App\Repositories\Interfaces\CompanyRepositoryInterface;

class CompanyService
{
    protected CompanyRepositoryInterface $repository;

    public function __construct(CompanyRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getCompaniesWithoutUser()
    {
        return $this->repository->companiesWithoutUser();
    }
}
