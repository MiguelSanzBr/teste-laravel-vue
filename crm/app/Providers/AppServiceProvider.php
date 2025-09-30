<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use App\Models\Colaborador;
use App\Policies\ColaboradorPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Colaborador::class => ColaboradorPolicy::class,
    ];

    public function boot(): void
    {
         Vite::prefetch(concurrency: 3);
       
        $this->registerPolicies();
    }
}
       

