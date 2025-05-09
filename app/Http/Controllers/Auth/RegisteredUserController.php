<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StoreUserRequest;
use App\Models\User;
use App\Traits\HasApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    use HasApiResponse;

    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $validated = $request->validated();

        if (User::where('role', 'admin')->exists()) {
            throw new Exception('O sistema já possui um administrador registrado!');
        }

        $validated['role'] = 'admin';
        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);
        Auth::login($user);

        $token = $user->createToken($user->name . ' auth_token')->plainTextToken;

        return $this->successResponse([
            'token_type' => 'Bearer',
            'token' => $token,
            'user' => $user,
            'redirect_url' => route('admin.dashboard'),
        ], 'Created', 201);
    }
}
