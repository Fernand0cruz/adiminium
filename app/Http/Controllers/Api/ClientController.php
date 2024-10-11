<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ClientController extends Controller
{
    public function index()
    {
        $clients = User::where('role', 'client')->get();
        return response()->json([
            'clients' => $clients
        ], 200);
    }

    public function show($id)
    {
        $client = User::findOrFail($id);

        return response()->json([
            'client' => $client,
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'company' => 'required|string|max:255|unique:' . User::class,
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'phone' => 'required|string|lowercase|min:15|max:16|unique:' . User::class,
            'regex:/^[0-9\s\-\(\)]+$/',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'company' => $request->company,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => 'client',
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        return response()->json(['success' => 'Cliente criado com sucesso!'], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'company' => 'required|string|max:255',Rule::unique(User::class)->ignore($id),
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255',Rule::unique(User::class)->ignore($id),
            'phone' => 'required|string|lowercase|min:15|max:16',Rule::unique(User::class)->ignore($id),
            'regex:/^[0-9\s\-\(\)]+$/',Rule::unique(User::class)->ignore($id),
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $client = User::findOrFail($id);

        $client->company = $request->company;
        $client->name = $request->name;
        $client->email = $request->email;
        $client->phone = $request->phone;

        if ($request->filled('password')) {
            $client->password = Hash::make($request->input('password'));
        }

        $client->save();

        return response()->json(['success' => 'Cliente atualizado com sucesso!'], 200);
    }

    public function destroy($id)
    {
        $client = User::findOrFail($id);
        $client->delete();

        return response()->json(['success' => 'Cliente excluido com sucesso.'], 200);
    }
}
