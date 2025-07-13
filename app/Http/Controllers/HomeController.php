<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke()
    {
        $imovelCards = [
            [
                'titulo' => 'Casa Moderna em Piabetá',
                'localizacao' => 'Rua das Flores, 123',
                'preco' => 'R$ 750.000',
                'quartos' => 3,
                'banheiros' => 4,
                'area' => '220 m²',
                'imagem' => 'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?q=80&w=1974&auto=format&fit=crop',
                'destaque' => 'Exclusividade',
                'bgDestaque' => 'bg-primary',
                'colSpan' => 'md:col-span-2 row-span-2',
            ],
            [
                'titulo' => 'Apartamento Aconchegante',
                'localizacao' => 'Centro, Magé',
                'preco' => 'R$ 320.000',
                'quartos' => 2,
                'banheiros' => 2,
                'area' => '75 m²',
                'imagem' => 'https://images.unsplash.com/photo-1570129477492-45c003edd2be?q=80&w=2070&auto=format&fit=crop',
                'destaque' => 'Oportunidade',
                'bgDestaque' => 'bg-green-600',
                'colSpan' => 'md:col-span-2',
            ],
            [
                'titulo' => 'Sítio Espaçoso',
                'localizacao' => 'Zona Rural, Magé',
                'preco' => 'R$ 1.200.000',
                'quartos' => 5,
                'banheiros' => 6,
                'area' => '5000 m²',
                'imagem' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=2070&auto=format&fit=crop',
                'destaque' => 'Destaque',
                'bgDestaque' => 'bg-primary',
            ],
            [
                'titulo' => 'Casa com Piscina',
                'localizacao' => 'Bairro X, Magé',
                'preco' => 'R$ 550.000',
                'quartos' => 4,
                'banheiros' => 3,
                'area' => '180 m²',
                'imagem' => 'https://images.unsplash.com/photo-1570129477492-45c003edd2be?q=80&w=2070&auto=format&fit=crop',
                'destaque' => 'Oportunidade',
                'bgDestaque' => 'bg-green-600',
            ],
            [
                'titulo' => 'Cobertura Luxuosa',
                'localizacao' => 'Centro, Magé',
                'preco' => 'R$ 2.000.000',
                'quartos' => 4,
                'banheiros' => 5,
                'area' => '350 m²',
                'imagem' => 'https://images.unsplash.com/photo-1512918728675-ed5a9ecdebfd?q=80&w=2070&auto=format&fit=crop',
                'destaque' => 'Luxo',
                'bgDestaque' => 'bg-yellow-500',
            ],
            [
                'titulo' => 'Apartamento Compacto',
                'localizacao' => 'Flexeiras, Magé',
                'preco' => 'R$ 180.000',
                'quartos' => 1,
                'banheiros' => 1,
                'area' => '45 m²',
                'imagem' => 'https://images.unsplash.com/photo-1465101178521-c1a9136a3fd9?q=80&w=2070&auto=format&fit=crop',
                'destaque' => 'Prático',
                'bgDestaque' => 'bg-blue-500',
            ],
        ];

        return view('welcome', compact('imovelCards'));
    }
}
