<?php

namespace Database\Factories;

use App\Models\Colaborador;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ColaboradorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Colaborador::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Lista de nomes brasileiros mais realistas
        $nomesMasculinos = [
            'João', 'Pedro', 'Lucas', 'Gabriel', 'Mateus', 'Rafael', 'Daniel', 'Marcos', 
            'Carlos', 'Paulo', 'Fernando', 'André', 'Ricardo', 'Bruno', 'Felipe'
        ];
        
        $nomesFemininos = [
            'Maria', 'Ana', 'Juliana', 'Patrícia', 'Aline', 'Camila', 'Larissa', 'Fernanda',
            'Amanda', 'Carolina', 'Beatriz', 'Isabela', 'Laura', 'Sofia', 'Cláudia'
        ];
        
        $sobrenomes = [
            'Silva', 'Santos', 'Oliveira', 'Souza', 'Rodrigues', 'Ferreira', 'Alves', 
            'Pereira', 'Lima', 'Costa', 'Ribeiro', 'Martins', 'Jesus', 'Carvalho'
        ];
        
        $genero = $this->faker->randomElement(['masculino', 'feminino']);
        
        if ($genero === 'masculino') {
            $nome = $this->faker->randomElement($nomesMasculinos) . ' ' . 
                   $this->faker->randomElement($sobrenomes) . ' ' . 
                   $this->faker->randomElement($sobrenomes);
        } else {
            $nome = $this->faker->randomElement($nomesFemininos) . ' ' . 
                   $this->faker->randomElement($sobrenomes) . ' ' . 
                   $this->faker->randomElement($sobrenomes);
        }

        return [
            'company_id' => User::factory(),
            'nome' => $nome,
            'telefone' => $this->gerarTelefone(),
            'email' => $this->gerarEmail($nome),
        ];
    }

    /**
     * Gera um número de telefone brasileiro válido
     */
    private function gerarTelefone(): string
    {
        $ddd = $this->faker->randomElement([
            '11', '21', '31', '41', '51', '61', '71', '81', '91', // Principais
            '12', '13', '14', '15', '16', '17', '18', '19', '22', // Outros DDDs
            '24', '27', '28', '32', '33', '34', '35', '37', '38'
        ]);
        $numero = $this->faker->numerify('9#########');
        return $ddd . $numero;
    }

    /**
     * Gera email baseado no nome
     */
    private function gerarEmail(string $nome): string
    {
        $provedores = ['gmail.com', 'hotmail.com', 'outlook.com', 'yahoo.com.br', 'empresa.com'];
        $nomeFormatado = strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $nome));
        $nomeFormatado = preg_replace('/[^a-z0-9]/', '.', $nomeFormatado);
        $nomeFormatado = preg_replace('/\.+/', '.', $nomeFormatado);
        $nomeFormatado = trim($nomeFormatado, '.');
        
        $partes = explode('.', $nomeFormatado);
        $email = $partes[0] . '.' . $partes[count($partes) - 1];
        
        return $email . '@' . $this->faker->randomElement($provedores);
    }

    /**
     * Indicate that the colaborador is inactive.
     */
    public function inativo(): static
    {
        return $this->state(fn (array $attributes) => [
            'deleted_at' => now(),
        ]);
    }

    /**
     * For a specific company.
     */
    public function forCompany(User $company): static
    {
        return $this->state(fn (array $attributes) => [
            'company_id' => $company->id,
        ]);
    }

    /**
     * With specific phone number.
     */
    public function withTelefone(string $telefone): static
    {
        return $this->state(fn (array $attributes) => [
            'telefone' => $telefone,
        ]);
    }

    /**
     * With specific email.
     */
    public function withEmail(string $email): static
    {
        return $this->state(fn (array $attributes) => [
            'email' => $email,
        ]);
    }

    /**
     * Colaborador do sexo masculino
     */
    public function masculino(): static
    {
        $nomesMasculinos = ['João', 'Pedro', 'Lucas', 'Gabriel', 'Mateus', 'Rafael'];
        $sobrenomes = ['Silva', 'Santos', 'Oliveira', 'Souza'];
        
        return $this->state(fn (array $attributes) => [
            'nome' => $this->faker->randomElement($nomesMasculinos) . ' ' . 
                     $this->faker->randomElement($sobrenomes) . ' ' . 
                     $this->faker->randomElement($sobrenomes),
        ]);
    }

    /**
     * Colaborador do sexo feminino
     */
    public function feminino(): static
    {
        $nomesFemininos = ['Maria', 'Ana', 'Juliana', 'Patrícia', 'Aline', 'Camila'];
        $sobrenomes = ['Silva', 'Santos', 'Oliveira', 'Souza'];
        
        return $this->state(fn (array $attributes) => [
            'nome' => $this->faker->randomElement($nomesFemininos) . ' ' . 
                     $this->faker->randomElement($sobrenomes) . ' ' . 
                     $this->faker->randomElement($sobrenomes),
        ]);
    }
}