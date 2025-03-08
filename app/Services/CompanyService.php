<?php

namespace App\Services;

use App\Models\Company;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;


class CompanyService
{
    public function getAllCompanies(): LengthAwarePaginator
    {
        return Company::paginate(25);
    }

    public function createCompany(array $data): Company
    {
        $photoPath = $this->handlePhotoUpload($data);

        $data['photo'] = $photoPath;

        return Company::create($data);
    }

    private function handlePhotoUpload(array &$data): ?string
    {
        if (isset($data['photo']) && $data['photo'] instanceof UploadedFile) {
            return $data['photo']->store('photos', 'public');
        }

        return null;
    }
}
