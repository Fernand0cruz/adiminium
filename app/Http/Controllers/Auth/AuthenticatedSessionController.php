<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Traits\HasApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    use HasApiResponse;

    public function create(): Response
    {
        return Inertia::render('Auth/Login');
    }

    /**
     * @throws ValidationException
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = $request->user();
        $token = $user->createToken($user->name . ' Auth-Token')->plainTextToken;

        return $this->successResponse([
            'token_type' => 'Bearer',
            'token' => $token,
            'user' => $user,
            'redirect_url' => $user->role === 'admin' ? route('admin.dashboard') : route('products.catalog.index'),
        ], 'Logged', 200);

    }

    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();

        $user->tokens()->delete();

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
