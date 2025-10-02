<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/ForgotPassword', [
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'cnpj' => 'required|string|max:18',
        ]);

        // Limpar e formatar o CNPJ
        $cnpj = preg_replace('/[^0-9]/', '', $request->cnpj);

        // Buscar usuário pelo CNPJ
        $user = User::where('cnpj', $cnpj)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'cnpj' => ['CNPJ não encontrado em nossa base de dados.'],
            ]);
        }

        // Gerar um token de reset
        $token = Str::random(60);
        
        // Salvar o token na tabela de password_reset_tokens
        DB::table('password_reset_tokens')->updateOrInsert(
            ['cnpj' => $cnpj], // Usamos o CNPJ como "email" para o sistema de reset
            [
                'token' => Hash::make($token),
                'created_at' => now()
            ]
        );
        // Por enquanto, vamos redirecionar para a página de reset com o token
        return redirect()->route('password.reset', ['token' => $token])->with('status', 'Token gerado com sucesso!');
    }
}