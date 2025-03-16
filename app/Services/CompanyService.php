<?php

namespace App\Services;

use App\Models\Company;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CompanyService
{
    public function createCompany(array $data): Company
    {
        $photoPath = $this->handlePhotoUpload($data);

        $data['photo'] = $photoPath;

        return Company::create($data);
    }

    public function getAllCompanies(): LengthAwarePaginator
    {
        return Company::select('id', 'user_id', 'photo', 'business_name', 'cnpj', 'phone', 'email', 'city')
            ->with([
                'User' => function ($query) {
                    $query->select('id', 'name');
                }
            ])
            ->paginate(25);
    }

    public function getCompanyById(int $id): Company
    {
        return Company::with('User')->findOrFail($id);
    }

    public function updateCompany(int $id, array $data): Company
    {
        $company = Company::findOrFail($id);

        if (isset($data['photo']) && $data['photo'] instanceof UploadedFile) {
            $this->deleteOldPhoto($company);
            $data['photo'] = $this->handlePhotoUpload($data);
        }

        $company->update($data);

        return $company;
    }

    public function deleteCompany(int $id): Company
    {
        $company = Company::findOrFail($id);

        $this->deleteOldPhoto($company);

        $company->delete();

        return $company;
    }

    public function getCompaniesUnsign(): Collection
    {
        return Company::select('id', 'business_name')
            ->whereNull('user_id')
            ->get();
    }

    private function handlePhotoUpload(array $data): ?string
    {
        if (isset($data['photo']) && $data['photo'] instanceof UploadedFile) {
            return $data['photo']->store('photos', 'public');
        }

        return null;
    }

    private function deleteOldPhoto(Company $company): void
    {
        if ($company->photo) {
            Storage::disk('public')->delete($company->photo);
        }
    }
}
