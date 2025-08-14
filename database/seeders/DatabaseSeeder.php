<?php

namespace Database\Seeders;

use App\Models\Imovel;
use App\Models\StatusImovel;
use App\Models\TipoImovel;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Exemplos de uso das factories:
        // User::factory(10)->create(); // Cria 10 usuários aleatórios
        // User::factory()->admin()->create(); // Cria um usuário admin
        // User::factory(5)->corretor()->create(); // Cria 5 corretores
        //
        // TipoImovel::factory(3)->create(); // Cria 3 tipos aleatórios
        // StatusImovel::factory(2)->create(); // Cria 2 status aleatórios

        // Imovel::factory(20)->create(); // Cria 20 imóveis aleatórios
        // Imovel::factory(5)->featured()->create(); // Cria 5 imóveis em destaque
        // Imovel::factory(10)->house()->create(); // Cria 10 casas
        // Imovel::factory(8)->apartment()->available()->create(); // Cria 8 apartamentos disponíveis

        $this->call([
            AdminUserSeeder::class,
            TipoImovelSeeder::class,
            StatusImovelSeeder::class,
            ImovelSeeder::class,
        ]);
    }
}
