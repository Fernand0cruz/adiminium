<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    //funcao alterada para gerar token para a auth da api ao logar user
    public function store(LoginRequest $request): JsonResponse
    {
        try {
            $request->authenticate();
        } catch (\Illuminate\Auth\AuthenticationException $e) {
            return response()->json([
                'error' => 'Credenciais inválidas.',
            ], 401); 
        }

        $request->session()->regenerate();

        $user = $request->user();

        $token = $user->createToken($user->name . 'Auth-Token')->plainTextToken;

        return response()->json([
            'success' => 'Login bem-sucedido',
            'token_type' => 'Bearer',
            'token' => $token,
            'redirect_url' => $user->role === 'admin' ? route('home') : route('products'),
        ], 200); 
    }


    /**
     * Destroy an authenticated session.
     */
    //funcao alterada para destruir o token de auth da api ao deslogar user
    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user) {
            $user->tokens()->delete(); 
        }
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
