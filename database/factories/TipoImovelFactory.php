<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TipoImovel>
 */
class TipoImovelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tipos = [
            'Casa',
            'Apartamento',
            'Apartamento Duplex',
            'Chalé',
            'Kitnet',
            'Sobrado',
            'Comercial',
            'Loja',
            'Galpão',
            'Pousada',
            'Prédio',
            'Sala',
            'Terreno',
            'Sítio',
            'Lote',
        ];

        return [
            'nome' => fake()->randomElement($tipos),
        ];
    }
}
