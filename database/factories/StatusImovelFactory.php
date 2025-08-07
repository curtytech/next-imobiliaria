<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\StatusImovel;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StatusImovel>
 */
class StatusImovelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = [
            'Disponível',
            'Vendido',
            'Alugado',
            'Reservado',
            'Em Negociação',
            'Indisponível',
        ];

        return [
            'nome' => fake()->randomElement($status),
        ];
    }
}