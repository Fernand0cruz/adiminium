<?php

namespace App\Services;

use App\Exceptions\AdminAlreadyExistsException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function createAdminUser(array $Data): User
    {
        if (User::where('role', 'admin')->exists()) {
            throw new AdminAlreadyExistsException();
        }

        $Data['role'] = 'admin';
        $Data['password'] = Hash::make($Data['password']);

        $user = User::create($Data);
        Auth::login($user);

        return $user;
    }
}
