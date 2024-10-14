<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
     //funcao alterada para gerar token para a auth da api ao registrar user
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if (User::where('role', 'admin')->exists()) {
            return response()->json([
                'error' => 'Já existe um ADMIN no sistema',
            ], 409);
        }

        $user = User::create([
            'company' => 'admin',
            'name' => $request->name,
            'email' => $request->email,
            'phone' => '',
            'role' => 'admin',
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken($user->name . 'Auth-Token')->plainTextToken;
        
        Auth::login($user);

        if ($user) {

            return response()->json([
                'success' => 'Cadastro bem-sucedido',
                'token_type' => 'Bearer',
                'token' => $token,
                'redirect_url' => route('home'), 
            ], 201);
        }
        return response()->json([
            'error' => 'Erro no cadastro',
        ], 500);
    }
}
