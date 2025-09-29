<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Colaborador extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'colaboradores';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_id',
        'nome',
        'telefone',
        'email',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        // Pode adicionar campos sensíveis se necessário
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * Get the company that owns the colaborador.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(User::class, 'company_id');
    }

    /**
     * Scope para filtrar colaboradores por empresa.
     */
    public function scopeDaCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    /**
     * Scope para colaboradores ativos (não deletados).
     */
    public function scopeAtivos($query)
    {
        return $query->whereNull('deleted_at');
    }

    /**
     * Scope para colaboradores inativos (deletados).
     */
    public function scopeInativos($query)
    {
        return $query->whereNotNull('deleted_at');
    }

    /**
     * Scope para buscar colaborador por telefone dentro de uma empresa.
     */
    public function scopePorTelefone($query, $companyId, $telefone)
    {
        return $query->where('company_id', $companyId)
                    ->where('telefone', $telefone);
    }

    /**
     * Scope para buscar colaborador por email dentro de uma empresa.
     */
    public function scopePorEmail($query, $companyId, $email)
    {
        return $query->where('company_id', $companyId)
                    ->where('email', $email);
    }

    /**
     * Verifica se o colaborador está ativo.
     */
    public function isAtivo(): bool
    {
        return is_null($this->deleted_at);
    }

    /**
     * Ativa um colaborador (remove soft delete).
     */
    public function ativar(): bool
    {
        return $this->restore();
    }

    /**
     * Desativa um colaborador (soft delete).
     */
    public function desativar(): bool
    {
        return $this->delete();
    }

    /**
     * Formata o telefone para exibição.
     */
    public function getTelefoneFormatadoAttribute(): string
    {
        $telefone = $this->telefone;
        
        // Formatação básica de telefone
        if (strlen($telefone) === 11) {
            return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $telefone);
        } elseif (strlen($telefone) === 10) {
            return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $telefone);
        }
        
        return $telefone;
    }

    /**
     * Get the colaborador's full name with company info.
     */
    public function getNomeCompletoAttribute(): string
    {
        return $this->nome;
    }

    /**
     * Boot method for model events.
     */
    protected static function boot()
    {
        parent::boot();

        // Evento para disparar email de boas-vindas
        static::created(function ($colaborador) {
            // Disparar email de boas-vindas
            // $colaborador->notify(new ColaboradorBoasVindas());
        });

        // Validação adicional antes de criar
        static::creating(function ($colaborador) {
            // Garante que não há duplicatas ativas
            $exists = self::daCompany($colaborador->company_id)
                        ->porTelefone($colaborador->company_id, $colaborador->telefone)
                        ->ativos()
                        ->exists();

            if ($exists) {
                throw new \Exception('Já existe um colaborador ativo com este telefone na empresa.');
            }

            $exists = self::daCompany($colaborador->company_id)
                        ->porEmail($colaborador->company_id, $colaborador->email)
                        ->ativos()
                        ->exists();

            if ($exists) {
                throw new \Exception('Já existe um colaborador ativo com este email na empresa.');
            }
        });
    }
}