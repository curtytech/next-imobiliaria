<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Imovel;
use App\Models\TipoImovel;
use App\Models\StatusImovel;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Imovel>
 */
class ImovelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $area = fake()->numberBetween(30, 500);
        $quartos = fake()->numberBetween(1, 5);
        $banheiros = fake()->numberBetween(1, 4);

        return [
            'titulo' => fake()->sentence(4),
            'descricao' => fake()->paragraph(3),
            'tipo_id' => TipoImovel::factory(),
            'status_id' => StatusImovel::factory(),
            'preco' => fake()->randomFloat(2, 100000, 2000000),
            'preco_iptu' => fake()->optional(0.7)->randomFloat(2, 100, 2000),
            'preco_condominio' => fake()->optional(0.6)->randomFloat(2, 200, 1500),
            'area' => $area,
            'quartos' => $quartos,
            'banheiros' => $banheiros,
            'vagas_garagem' => fake()->numberBetween(0, 4),
            'endereco' => fake()->streetAddress(),
            'bairro' => fake()->citySuffix(),
            'cidade' => fake()->city(),
            'estado' => fake()->stateAbbr(),
            'pais' => 'Brasil',
            // Cep deve ser salvo sem hífen ou qualquer outro caracter que não seja um número
            'cep' => str_replace(['-', ' '], '', fake()->postcode()),
            // localização do mapa deve ser um link para o google maps
            'localizacao_maps' => 'https://www.google.com/maps/place/' . fake()->latitude(-23, -22) . ',' . fake()->longitude(-44, -43),
            'caracteristicas' => [
                'Piscina' => fake()->randomElement(['Sim', 'Não']),
                'Churrasqueira' => fake()->randomElement(['Sim', 'Não']),
                'Academia' => fake()->randomElement(['Sim', 'Não']),
                'Playground' => fake()->randomElement(['Sim', 'Não']),
                'Portaria 24h' => fake()->randomElement(['Sim', 'Não']),
                'Elevador' => fake()->randomElement(['Sim', 'Não']),
            ],
            'fotos' => [
                'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?q=80&w=800&auto=format&fit=crop',
            ],
            'videos' => fake()->randomElements([
                'https://www.youtube.com/watch?v=hvi3J3yBRXI',
                'https://www.youtube.com/watch?v=y0sF5xhGreA',
            ], fake()->numberBetween(0, 2)),
            'destaque' => fake()->boolean(20), // 20% chance de ser destaque
            'area_util' => fake()->optional(0.8)->numberBetween($area - 20, $area),
            'terreno' => fake()->optional(0.4)->numberBetween($area, $area * 3),
            'area_constr' => fake()->optional(0.9)->numberBetween($area - 10, $area + 50),
            'user_id' => User::factory(),
        ];
    }

    /**
     * Indicate that the property should be featured.
     */
    public function featured(): static
    {
        return $this->state(fn(array $attributes) => [
            'destaque' => true,
        ]);
    }

    /**
     * Indicate that the property is available.
     */
    public function available(): static
    {
        return $this->state(function (array $attributes) {
            $availableStatus = StatusImovel::where('nome', 'Disponível')->first();
            return [
                'status_id' => $availableStatus ? $availableStatus->id : StatusImovel::factory(),
            ];
        });
    }

    /**
     * Indicate that the property is a house.
     */
    public function house(): static
    {
        return $this->state(function (array $attributes) {
            $houseType = TipoImovel::where('nome', 'Casa')->first();
            return [
                'tipo_id' => $houseType ? $houseType->id : TipoImovel::factory(),
                'terreno' => fake()->numberBetween(200, 1000),
            ];
        });
    }

    /**
     * Indicate that the property is an apartment.
     */
    public function apartment(): static
    {
        return $this->state(function (array $attributes) {
            $apartmentType = TipoImovel::where('nome', 'Apartamento')->first();
            return [
                'tipo_id' => $apartmentType ? $apartmentType->id : TipoImovel::factory(),
                'terreno' => null,
                'preco_condominio' => fake()->randomFloat(2, 300, 1200),
            ];
        });
    }
}
