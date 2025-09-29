<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
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
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'cnpj' => ['required', 'string', 'max:18', 'unique:'.User::class],
            'nmfs' => ['required', 'string', 'max:255'],
            'rsl' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Remove a máscara do CNPJ para salvar apenas números
        $cnpjSemMascara = preg_replace('/[^0-9]/', '', $request->cnpj);

        $user = User::create([
            'cnpj' => $cnpjSemMascara, // Salva sem máscara
            'cnpj_formatado' => $request->cnpj, // Salva com máscara (se tiver este campo)
            'nmfs' => $request->nmfs,
            'rsl' => $request->rsl,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}