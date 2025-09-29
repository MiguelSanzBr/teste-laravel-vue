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
        return [
            'company_id' => User::factory(),
            'nome' => $this->faker->name(),
            'telefone' => $this->gerarTelefone(),
            'email' => $this->faker->unique()->safeEmail(),
        ];
    }

    /**
     * Gera um número de telefone brasileiro válido
     */
    private function gerarTelefone(): string
    {
        $ddd = $this->faker->randomElement(['11', '21', '31', '41', '51', '61', '71', '81', '91']);
        $numero = $this->faker->numerify('9#########');
        return $ddd . $numero;
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
}