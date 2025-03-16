<?php

namespace App\Services;

use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\LengthAwarePaginator;

class ClientService
{
    public function createClient(array $data): User
    {
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        $company = Company::find($data['company_id']);

        if ($company) {
            $company->user_id = $user->id;
            $company->save();
        }

        return $user;
    }

    public function getAllClients(): LengthAwarePaginator
    {
        return User::with('Company')
            ->paginate(25);
    }

    public function getClientById(int $id): User
    {
        return User::with('company')->findOrFail($id);
    }

    public function updateClient(int $id, array $data): User
    {
        $client = User::findOrFail($id);

        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $client->update($data);

        return $client;
    }

    public function deleteClient(int $id): User
    {
        $client = User::findOrFail($id);

        $client->delete();

        return $client;
    }
}
