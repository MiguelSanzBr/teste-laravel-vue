<?php

namespace App\Mail;

use App\Models\Colaborador;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class ColaboradorCriado extends Mailable
{
    use Queueable, SerializesModels;

    public $colaborador;
    public $empresaNome;

    public function __construct(Colaborador $colaborador)
    {
        $this->colaborador = $colaborador;
        $this->empresaNome = Auth::user()->rsl; 
    }

    public function build()
    {
        return $this->subject("Bem-vindo à {$this->empresaNome}!")
                    ->view('emails.colaborador-criado')
                    ->with([
                        'nome' => $this->colaborador->nome,
                        'email' => $this->colaborador->email,
                        'empresaNome' => $this->empresaNome,
                    ]);
    }
}