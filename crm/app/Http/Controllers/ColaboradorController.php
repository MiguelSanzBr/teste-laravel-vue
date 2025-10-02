<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use App\Mail\ColaboradorCriado;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ColaboradorController extends Controller
{
    private function getCompanyId()
    {
        return Auth::user()->id;
    }

    private function buildColaboradorResource(Colaborador $colaborador): array
    {
        return [
            'id' => $colaborador->id,
            'nome' => $colaborador->nome,
            'telefone' => $colaborador->telefone_formatado,
            'email' => $colaborador->email,
            'company_id' => $colaborador->company_id,
            'created_at' => $colaborador->created_at?->format('d/m/Y H:i'),
            'updated_at' => $colaborador->updated_at?->format('d/m/Y H:i'),
            'ativo' => $colaborador->isAtivo(),
        ];
    }

    private function buildInativoResource(Colaborador $colaborador): array
    {
        return [
            'id' => $colaborador->id,
            'nome' => $colaborador->nome,
            'telefone' => $colaborador->telefone_formatado,
            'email' => $colaborador->email,
            'deleted_at' => $colaborador->deleted_at?->format('d/m/Y H:i'),
        ];
    }

    private function getValidationRules(int $companyId, ?Colaborador $colaborador = null): array
    {
        $uniqueRule = function ($field) use ($companyId, $colaborador) {
            $rule = Rule::unique('colaboradores')->where(function ($query) use ($companyId) {
                return $query->where('company_id', $companyId)
                           ->whereNull('deleted_at');
            });

            if ($colaborador) {
                $rule->where('id', '!=', $colaborador->id);
            }

            return $rule;
        };

        return [
            'nome' => 'required|string|max:255',
            'email' => ['required', 'email', $uniqueRule('email')],
            'telefone' => ['required', 'string', 'max:20', $uniqueRule('telefone')],
        ];
    }

    private function getValidationMessages(): array
    {
        return [
            'email.unique' => 'Já existe um colaborador ativo com este email na sua empresa.',
            'telefone.unique' => 'Já existe um colaborador ativo com este telefone na sua empresa.',
        ];
    }

    private function checkPermission(Colaborador $colaborador): bool
    {
        return $colaborador->company_id === $this->getCompanyId();
    }

    private function redirectUnauthorized()
    {
        return Redirect::route('colaboradores.index')
            ->with('error', 'Você não tem permissão para executar esta ação.');
    }

    private function handleDatabaseException(\Exception $e, ?Request $request = null)
    {
        Log::error('Database error: ' . $e->getMessage());

        $response = Redirect::back()->with('error', $this->getErrorMessage($e));

        if ($request) {
            $response->withInput();
        }

        return $response;
    }

    private function getErrorMessage(\Exception $e): string
    {
        if (str_contains($e->getMessage(), 'colaboradores_company_id_telefone_unique')) {
            return 'Já existe um colaborador com este telefone na sua empresa.';
        }

        if (str_contains($e->getMessage(), 'colaboradores_company_id_email_unique')) {
            return 'Já existe um colaborador com este email na sua empresa.';
        }

        return 'Erro ao processar a solicitação: ' . $e->getMessage();
    }

    private function findDeletedColaborador(array $validated): ?Colaborador
    {
        return Colaborador::withTrashed()
            ->where('company_id', $this->getCompanyId())
            ->where(function ($query) use ($validated) {
                $query->where('email', $validated['email'])
                      ->orWhere('telefone', $validated['telefone']);
            })
            ->whereNotNull('deleted_at')
            ->first();
    }

    private function restoreOrCreateColaborador(array $validated): Colaborador
    {
        $colaboradorDeletado = $this->findDeletedColaborador($validated);

        if ($colaboradorDeletado) {
            Log::info('Restaurando colaborador deletado: ' . $colaboradorDeletado->id);
            
            $colaboradorDeletado->restore();
            $colaboradorDeletado->update($validated);
            
            return $colaboradorDeletado;
        }

        return Colaborador::create([
            ...$validated,
            'company_id' => $this->getCompanyId(),
        ]);
    }

    private function sendWelcomeEmail(Colaborador $colaborador): void
    {
        try {
            Mail::to($colaborador->email)->send(new ColaboradorCriado($colaborador));
            Log::info('Email enviado com sucesso para: ' . $colaborador->email);
        } catch (\Exception $e) {
            Log::error('Falha ao enviar email: ' . $e->getMessage());
        }
    }

        private function buildSearchQuery(?string $search): callable
    {
        return function ($query) use ($search) {
            if (empty($search)) {
                return;
            }
            
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('telefone', 'like', "%{$search}%");
            });
        };
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $colaboradores = Colaborador::daCompany($this->getCompanyId())
            ->ativos()
            ->when($request->search, $this->buildSearchQuery($request->search))
            ->latest()
            ->paginate(10)
            ->through(fn ($colaborador) => $this->buildColaboradorResource($colaborador));

        return Inertia::render('Colaboradores', [
            'colaboradores' => $colaboradores,
            'filters' => $request->only(['search']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            $this->getValidationRules($this->getCompanyId()),
            $this->getValidationMessages()
        );

        try {
            Log::info('Iniciando criação do colaborador: ' . $validated['email']);
            
            $colaborador = $this->restoreOrCreateColaborador($validated);
            Log::info('Colaborador processado com ID: ' . $colaborador->id);

            $this->sendWelcomeEmail($colaborador);

            return Redirect::route('colaboradores.index')
                ->with('success', 'Colaborador criado com sucesso! E-mail enviado.');
            
        } catch (\Exception $e) {
            Log::error('Erro no store do colaborador: ' . $e->getMessage());
            return $this->handleDatabaseException($e, $request);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Colaborador $colaborador)
    {
        if (!$this->checkPermission($colaborador)) {
            return $this->redirectUnauthorized();
        }

        return Inertia::render('Colaboradores/Show', [
            'colaborador' => $this->buildColaboradorResource($colaborador),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Colaborador $colaborador)
    {
        if (!$this->checkPermission($colaborador)) {
            return $this->redirectUnauthorized();
        }

        $validated = $request->validate(
            $this->getValidationRules($this->getCompanyId(), $colaborador),
            $this->getValidationMessages()
        );

        try {
            $colaborador->update($validated);

            return Redirect::route('colaboradores.index')
                ->with('success', 'Colaborador atualizado com sucesso!');
                
        } catch (\Exception $e) {
            return $this->handleDatabaseException($e, $request);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Colaborador $colaborador)
    {
        if (!$this->checkPermission($colaborador)) {
            return $this->redirectUnauthorized();
        }

        try {
            $colaborador->delete();

            return Redirect::route('colaboradores.index')
                ->with('success', 'Colaborador excluído com sucesso!');
                
        } catch (\Exception $e) {
            return $this->handleDatabaseException($e);
        }
    }

    /**
     * Restaurar colaborador desativado
     */
    public function restore($id)
    {
        $colaborador = Colaborador::withTrashed()->findOrFail($id);
        
        if (!$this->checkPermission($colaborador)) {
            return $this->redirectUnauthorized();
        }

        try {
            $colaborador->restore();

            return Redirect::route('colaboradores.index')
                ->with('success', 'Colaborador ativado com sucesso!');
                
        } catch (\Exception $e) {
            return $this->handleDatabaseException($e);
        }
    }

    /**
     * Lista de colaboradores desativados
     */
    public function inativos(Request $request)
    {
        $colaboradores = Colaborador::daCompany($this->getCompanyId())
            ->inativos()
            ->when($request->search, $this->buildSearchQuery($request->search))
            ->latest()
            ->paginate(10)
            ->through(fn ($colaborador) => $this->buildInativoResource($colaborador));

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
        $colaboradores = Colaborador::daCompany($this->getCompanyId())
            ->ativos()
            ->when($request->search, $this->buildSearchQuery($request->search))
            ->limit(10)
            ->get()
            ->map(fn ($colaborador) => $this->buildColaboradorResource($colaborador));

        return response()->json($colaboradores);
    }
}