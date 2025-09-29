<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Colaborador;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $cnpjTeste = '12345678000190';
        $usuarioTeste = User::where('cnpj', $cnpjTeste)->first();

        if (!$usuarioTeste) {
            $usuarioTeste = User::factory()->create([
                'cnpj' => $cnpjTeste,
                'nmfs' => 'Empresa Teste Ltda',
                'rsl' => 'Empresa Teste Razão Social Ltda',
                'password' => bcrypt('password123'),
            ]);
            $this->command->info('Usuário teste criado.');
        } else {
            $this->command->info('Usuário teste já existe.');
        }

        $totalEmpresas = User::count();

        if ($totalEmpresas < 4) {
            $empresasNecessarias = 4 - $totalEmpresas;
            $this->command->info($empresasNecessarias . ' novas empresas criadas.');
        } else {
            $this->command->info('Número suficiente de empresas já existe.');
        }

        $empresas = User::all();

        foreach ($empresas as $empresa) {
            $colaboradoresCount = Colaborador::where('company_id', $empresa->id)->count();
            
            if ($colaboradoresCount === 0) {
                Colaborador::factory(rand(3, 5))
                    ->forCompany($empresa)
                    ->create();

                Colaborador::factory(rand(1, 2))
                    ->forCompany($empresa)
                    ->inativo()
                    ->create();

                $this->command->info('Colaboradores criados para empresa: ' . $empresa->nmfs);
            } else {
                $this->command->info('Empresa ' . $empresa->nmfs . ' já tem ' . $colaboradoresCount . ' colaboradores.');
            }
        }

        $colaboradorJoao = Colaborador::where('company_id', $usuarioTeste->id)
            ->where('email', 'joao@empresa.com')
            ->first();

        if (!$colaboradorJoao) {
            Colaborador::factory()->create([
                'company_id' => $usuarioTeste->id,
                'nome' => 'João Silva',
                'telefone' => '11999999999',
                'email' => 'joao@empresa.com',
            ]);
        }

        $colaboradorMaria = Colaborador::where('company_id', $usuarioTeste->id)
            ->where('email', 'maria@empresa.com')
            ->first();

        if (!$colaboradorMaria) {
            Colaborador::factory()->create([
                'company_id' => $usuarioTeste->id,
                'nome' => 'Maria Santos',
                'telefone' => '11888888888',
                'email' => 'maria@empresa.com',
            ]);
        }

        // Output no console
        $this->command->info('Database seeding completed!');
        $this->command->info('Total de empresas: ' . $empresas->count());
        $this->command->info('Total de colaboradores: ' . Colaborador::count());
        $this->command->info('Credenciais de teste:');
        $this->command->info('CNPJ: 12345678000190');
        $this->command->info('Senha: password123');
    }
}