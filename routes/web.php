<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\PropertySearchResults;
use App\Models\Imovel;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/search', PropertySearchResults::class)->name('properties.search');

Route::get('/imovel/{id}', function ($id) {
    // Dados fake para visualização
    $imovel = (object) [
        'id' => $id,
        'titulo' => 'Sobrado Centro - Magé',
        'endereco' => 'Rua Major Magalhães - Centro - Magé - RJ',
        'codigo' => '502',
        'area_util' => 120,
        'area_construida' => 120,
        'dormitorios' => 3,
        'banheiros' => 2,
        'suites' => 1,
        'descricao' => 'Este sobrado localizado no Centro de Magé é a opção perfeita para quem busca conforto e praticidade em um só lugar. Com 3 dormitórios, é ideal para famílias que desejam um espaço amplo e aconchegante para viver. Além disso, o imóvel conta com 2 banheiros, garantindo a comodidade de todos os moradores.',
        'descricao_extra' => 'O sobrado possui uma estrutura moderna e bem distribuída, com ambientes iluminados e arejados. A cozinha é espaçosa, oferecendo praticidade no dia a dia. A sala de estar é aconchegante e perfeita para reunir a família e receber amigos.',
        'descricao_final' => 'Este sobrado é uma excelente oportunidade para quem busca um imóvel de qualidade e com um preço justo. Não perca a chance de morar em um lugar que oferece conforto, praticidade e segurança.',
        'telefone' => '21 2633-2403',
        'whatsapp' => '21 98335-7879',
        'fotos' => [
            'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?q=80&w=800',
            'https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=800',
            'https://images.unsplash.com/photo-1460518451285-97b6aa326961?q=80&w=800',
            'https://images.unsplash.com/photo-1472224371017-08207f84aaae?q=80&w=800',
        ],
        'video' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        'mapa' => 'https://www.google.com/maps?q=Centro+Magé+RJ&output=embed',
        'streetview' => 'https://www.google.com/maps?q=Centro+Magé+RJ&layer=c&cbll=-22.6556,-43.0319&cbp=11,0,0,0,0&output=svembed',
    ];
    return view('imovel.detalhes', compact('imovel'));
});
