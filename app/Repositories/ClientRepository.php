<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ClientRepository implements ClientRepositoryInterface
{
    public function all(): LengthAwarePaginator
    {
        return User::with('company')->paginate(15);
    }

    public function find($id)
    {
        return User::with('company')->find($id);
    }

    public function create(array $data)
    {
        return User::create($data);
    }

    public function update($id, array $data)
    {
        $user = User::find($id);
        if (!$user) return null;

        $user->update($data);
        return $user;
    }

    public function delete($id)
    {
        $user = User::find($id);
        if (!$user) return false;

        return $user->delete();
    }
}
