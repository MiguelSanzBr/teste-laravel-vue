<?php

namespace App\Services;

use App\Models\Colaborador;
use Illuminate\Support\Facades\Auth;

class DashboardService
{
    public function getColaboradoresStats()
    {
        $companyId = Auth::user()->id;
        $now = now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();

        return [
            'cadastrados_mes' => Colaborador::daCompany($companyId)
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->count(),

            'demitidos_mes' => Colaborador::daCompany($companyId)
                ->onlyTrashed()
                ->whereBetween('deleted_at', [$startOfMonth, $endOfMonth])
                ->count(),

            'total_ativos' => Colaborador::daCompany($companyId)
                ->ativos()
                ->count(),
        ];
    }

    // Método para evolução mensal (opcional)
    public function getEvolucaoMensal($meses = 6)
    {
        $companyId = Auth::user()->id;
        $now = now();
        
        $stats = [];
        for ($i = $meses - 1; $i >= 0; $i--) {
            $month = $now->copy()->subMonths($i);
            $startOfMonth = $month->copy()->startOfMonth();
            $endOfMonth = $month->copy()->endOfMonth();

            $stats[] = [
                'mes' => $month->format('Y-m'),
                'mes_nome' => $month->translatedFormat('F Y'),
                'cadastrados' => Colaborador::daCompany($companyId)
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                    ->count(),
                'demitidos' => Colaborador::daCompany($companyId)
                    ->onlyTrashed()
                    ->whereBetween('deleted_at', [$startOfMonth, $endOfMonth])
                    ->count(),
            ];
        }

        return $stats;
    }

    // Método para dados do gráfico (opcional)
    public function getDadosGrafico($meses = 6)
    {
        $companyId = Auth::user()->id;
        $now = now();
        
        $dados = [];
        $labels = [];
        
        for ($i = $meses - 1; $i >= 0; $i--) {
            $month = $now->copy()->subMonths($i);
            $startOfMonth = $month->copy()->startOfMonth();
            $endOfMonth = $month->copy()->endOfMonth();

            $labels[] = $month->translatedFormat('M/Y');
            
            $dados['cadastrados'][] = Colaborador::daCompany($companyId)
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->count();
                
            $dados['demitidos'][] = Colaborador::daCompany($companyId)
                ->onlyTrashed()
                ->whereBetween('deleted_at', [$startOfMonth, $endOfMonth])
                ->count();
        }

        return [
            'labels' => $labels,
            'datasets' => $dados
        ];
    }
}