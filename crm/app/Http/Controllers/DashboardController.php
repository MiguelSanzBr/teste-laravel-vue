<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Inertia\Inertia;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $stats = $this->dashboardService->getColaboradoresStats();
        $evolucaoMensal = $this->dashboardService->getEvolucaoMensal(6);

        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'evolucaoMensal' => $evolucaoMensal,
        ]);
    }
}