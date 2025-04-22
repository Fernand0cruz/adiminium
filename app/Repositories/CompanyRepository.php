<?php

namespace App\Repositories;

use App\Models\Company;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class CompanyRepository implements CompanyRepositoryInterface
{
    public function all(): LengthAwarePaginator
    {
        return Company::with('user')->paginate(15);
    }

    public function find($id)
    {
        return Company::with('user')->find($id);
    }

    public function create(array $data)
    {
        return Company::create($data);
    }

    public function update($id, array $data)
    {
        $company = Company::find($id);
        if (!$company) return null;

        $company->update($data);
        return $company;
    }

    public function delete($id)
    {
        $company = Company::find($id);
        if (!$company) return false;

        return $company->delete();
    }

    public function companiesWithoutUser()
    {
        return Company::whereDoesntHave('user')->get();
    }
}
