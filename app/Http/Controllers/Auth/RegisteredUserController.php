<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StoreUserRequest;
use App\Models\User;
use App\Traits\HandlesExceptions;
use Illuminate\Http\JsonResponse;
use App\Services\UserService;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    use HandlesExceptions;

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        return $this->handleExceptions(function () use ($request) {
            $validated = $request->validated();
            $user = $this->userService->createAdminUser($validated);
            $token = $user->createToken($user->name . ' Auth-Token')->plainTextToken;
            return $this->success([
                'token_type' => 'Bearer',
                'token' => $token,
                'redirect_url' => route('admin.dashboard'),
            ], 'User created successfully.', 201);
        });
    }
}
