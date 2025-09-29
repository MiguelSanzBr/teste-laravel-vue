<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'cnpj',
        'nmfs',
        'rsl',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Get the CNPJ for password reset.
     */
    public function getEmailForPasswordReset()
    {
        return $this->cnpj;
    }

    /**
     * Route notifications for the mail channel.
     * Como não temos email, retornamos null ou um valor padrão
     */
    public function routeNotificationForMail()
    {
        return null; // ou return $this->cnpj . '@sistema.com' se quiser usar CNPJ como "email"
    }
}