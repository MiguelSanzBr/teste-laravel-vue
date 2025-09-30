<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; // ADICIONAR ESTE IMPORT

class ColaboradorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $companyId = Auth::user()->id;

        $colaboradores = Colaborador::daCompany($companyId)
            ->ativos()
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nome', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('telefone', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->through(fn ($colaborador) => [
                'id' => $colaborador->id,
                'nome' => $colaborador->nome,
                'telefone' => $colaborador->telefone_formatado,
                'email' => $colaborador->email,
                'company_id' => $colaborador->company_id,
                'created_at' => $colaborador->created_at?->format('d/m/Y H:i'),
                'updated_at' => $colaborador->updated_at?->format('d/m/Y H:i'),
                'ativo' => $colaborador->isAtivo(),
            ]);

        return Inertia::render('Colaboradores/Index', [
            'colaboradores' => $colaboradores,
            'filters' => $request->only(['search']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $companyId = Auth::user()->id;

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('colaboradores')->where(function ($query) use ($companyId) {
                    return $query->where('company_id', $companyId)
                               ->whereNull('deleted_at');
                })
            ],
            'telefone' => [
                'required',
                'string',
                'max:20',
                Rule::unique('colaboradores')->where(function ($query) use ($companyId) {
                    return $query->where('company_id', $companyId)
                               ->whereNull('deleted_at');
                })
            ],
        ], [
            'email.unique' => 'Já existe um colaborador com este email na sua empresa.',
            'telefone.unique' => 'Já existe um colaborador com este telefone na sua empresa.',
        ]);

        try {
            Colaborador::create([
                ...$validated,
                'company_id' => $companyId,
            ]);

            return Redirect::route('colaboradores.index')
                ->with('success', 'Colaborador criado com sucesso!');
                
        } catch (\Exception $e) {
            // Captura erros de constraint do banco (fallback)
            if (str_contains($e->getMessage(), 'colaboradores_company_id_telefone_unique')) {
                return Redirect::back()
                    ->with('error', 'Já existe um colaborador com este telefone na sua empresa.')
                    ->withInput();
            }
            
            if (str_contains($e->getMessage(), 'colaboradores_company_id_email_unique')) {
                return Redirect::back()
                    ->with('error', 'Já existe um colaborador com este email na sua empresa.')
                    ->withInput();
            }

            return Redirect::back()
                ->with('error', 'Erro ao criar colaborador: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Colaborador $colaborador)
    {
        $companyId = Auth::user()->id;

        // Verificar se o colaborador pertence à company do usuário logado
        if ($colaborador->company_id !== $companyId) {
            return Redirect::route('colaboradores.index')
                ->with('error', 'Você não tem permissão para visualizar este colaborador.');
        }

        return Inertia::render('Colaboradores/Show', [
            'colaborador' => [
                'id' => $colaborador->id,
                'nome' => $colaborador->nome,
                'telefone' => $colaborador->telefone_formatado,
                'email' => $colaborador->email,
                'company_id' => $colaborador->company_id,
                'created_at' => $colaborador->created_at?->format('d/m/Y H:i'),
                'updated_at' => $colaborador->updated_at?->format('d/m/Y H:i'),
                'ativo' => $colaborador->isAtivo(),
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Colaborador $colaborador)
    {
        $companyId = Auth::user()->id;

        // Verificar se o colaborador pertence à company do usuário logado
        if ($colaborador->company_id !== $companyId) {
            return Redirect::route('colaboradores.index')
                ->with('error', 'Você não tem permissão para editar este colaborador.');
        }

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('colaboradores')->where(function ($query) use ($companyId, $colaborador) {
                    return $query->where('company_id', $companyId)
                               ->whereNull('deleted_at')
                               ->where('id', '!=', $colaborador->id);
                })
            ],
            'telefone' => [
                'required',
                'string',
                'max:20',
                Rule::unique('colaboradores')->where(function ($query) use ($companyId, $colaborador) {
                    return $query->where('company_id', $companyId)
                               ->whereNull('deleted_at')
                               ->where('id', '!=', $colaborador->id);
                })
            ],
        ], [
            'email.unique' => 'Já existe um colaborador com este email na sua empresa.',
            'telefone.unique' => 'Já existe um colaborador com este telefone na sua empresa.',
        ]);

        try {
            $colaborador->update($validated);

            return Redirect::route('colaboradores.index')
                ->with('success', 'Colaborador atualizado com sucesso!');
                
        } catch (\Exception $e) {
            // Captura erros de constraint do banco (fallback)
            if (str_contains($e->getMessage(), 'colaboradores_company_id_telefone_unique')) {
                return Redirect::back()
                    ->with('error', 'Já existe um colaborador com este telefone na sua empresa.')
                    ->withInput();
            }
            
            if (str_contains($e->getMessage(), 'colaboradores_company_id_email_unique')) {
                return Redirect::back()
                    ->with('error', 'Já existe um colaborador com este email na sua empresa.')
                    ->withInput();
            }

            return Redirect::back()
                ->with('error', 'Erro ao atualizar colaborador: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Colaborador $colaborador)
    {
        $companyId = Auth::user()->id;

        // Verificar se o colaborador pertence à company do usuário logado
        if ($colaborador->company_id !== $companyId) {
            return Redirect::route('colaboradores.index')
                ->with('error', 'Você não tem permissão para excluir este colaborador.');
        }

        try {
            $colaborador->delete();

            return Redirect::route('colaboradores.index')
                ->with('success', 'Colaborador excluído com sucesso!');
                
        } catch (\Exception $e) {
            return Redirect::back()
                ->with('error', 'Erro ao excluir colaborador: ' . $e->getMessage());
        }
    }

    /**
     * Restaurar colaborador desativado
     */
    public function restore($id)
    {
        $companyId = Auth::user()->id;
        $colaborador = Colaborador::withTrashed()->findOrFail($id);
        
        // Verificar se o colaborador pertence à company do usuário logado
        if ($colaborador->company_id !== $companyId) {
            return Redirect::route('colaboradores.index')
                ->with('error', 'Você não tem permissão para restaurar este colaborador.');
        }

        try {
            $colaborador->restore();

            return Redirect::route('colaboradores.index')
                ->with('success', 'Colaborador ativado com sucesso!');
                
        } catch (\Exception $e) {
            return Redirect::back()
                ->with('error', 'Erro ao ativar colaborador: ' . $e->getMessage());
        }
    }

    /**
     * Lista de colaboradores desativados
     */
    public function inativos(Request $request)
    {
        $companyId = Auth::user()->id;

        $colaboradores = Colaborador::daCompany($companyId)
            ->inativos()
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nome', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('telefone', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->through(fn ($colaborador) => [
                'id' => $colaborador->id,
                'nome' => $colaborador->nome,
                'telefone' => $colaborador->telefone_formatado,
                'email' => $colaborador->email,
                'deleted_at' => $colaborador->deleted_at?->format('d/m/Y H:i'),
            ]);

        return Inertia::render('Colaboradores/Inativos', [
            'colaboradores' => $colaboradores,
            'filters' => $request->only(['search']),
        ]);
    }

    /**
     * Buscar colaboradores para select/autocomplete
     */
    public function search(Request $request)
    {
        $companyId = Auth::user()->id;

        $colaboradores = Colaborador::daCompany($companyId)
            ->ativos()
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nome', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('telefone', 'like', "%{$search}%");
                });
            })
            ->limit(10)
            ->get()
            ->map(fn ($colaborador) => [
                'id' => $colaborador->id,
                'nome' => $colaborador->nome,
                'email' => $colaborador->email,
                'telefone' => $colaborador->telefone_formatado,
            ]);

        return response()->json($colaboradores);
    }
}