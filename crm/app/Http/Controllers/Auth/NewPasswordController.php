<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('Auth/ResetPassword', [
            'token' => $request->route('token'),
            'cnpj' => $request->input('cnpj', ''),
        ]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => 'required',
            'cnpj' => 'required|string|max:18',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $cnpj = preg_replace('/[^0-9]/', '', $request->cnpj);

        $resetRecord = DB::table('password_reset_tokens')
            ->where('cnpj', $cnpj)
            ->first();

        if (!$resetRecord) {
            throw ValidationException::withMessages([
                'cnpj' => ['Token inválido ou expirado.'],
            ]);
        }

        if (!Hash::check($request->token, $resetRecord->token)) {
            throw ValidationException::withMessages([
                'token' => ['Token inválido.'],
            ]);
        }

        $user = User::where('cnpj', $cnpj)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'cnpj' => ['CNPJ não encontrado.'],
            ]);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_reset_tokens')->where('cnpj', $cnpj)->delete();

        return redirect()->route('login')->with('status', 'Senha redefinida com sucesso!');
    }
}