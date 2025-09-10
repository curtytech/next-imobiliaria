<?php

use function Livewire\Volt\{state, layout};
use App\Models\Imovel;
use App\Models\TipoImovel;
use App\Models\User;

layout('components.layouts.app');

state([
    'imovelCards' => fn() => Imovel::with(['tipoImovel', 'statusImovel', 'corretor'])->where('destaque', true)->limit(6)->get(),
    'imoveisDisponiveis' => fn() => Imovel::where('status_id', 1)->orderBy('created_at', 'desc')->limit(15)->get(),
    'imovelCount' => fn() => Imovel::count(),
    'corretores' => fn() => User::where('role', 'corretor')->get(),
    'tipoImovel' => fn() => TipoImovel::all()
]);

?>

<main>
    <!-- Hero Section -->
    <section id="hero" class="relative min-h-[70vh] md:min-h-[80vh] flex items-center justify-center text-white">
        <div class="absolute inset-0 z-0 bg-center bg-no-repeat bg-cover"
            style="background-image: url('https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?q=80&w=2070&auto=format&fit=crop');">
            <div class="absolute inset-0 bg-black/50"></div>
        </div>
        <div class="relative z-10 px-4 text-center">
            <!-- <h1 class="mb-4 text-4xl font-extrabold drop-shadow-lg md:text-6xl">O seu imóvel dos sonhos em Magé</h1> -->
            <!-- <p class="mx-auto mb-8 max-w-3xl text-lg drop-shadow-md md:text-xl">Especializado em venda e locação de
                imóveis residenciais e comerciais na cidade de Magé.</p> -->
            <livewire:hero-search-form />
        </div>
    </section>
    <!-- Feature Highlights Section -->
    <section class="container relative z-20 px-4 mx-auto -mt-12 mb-12">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            <div class="flex flex-col items-center p-6 text-center bg-white rounded-xl shadow-lg">
                <i data-lucide="star" class="mb-2 w-8 h-8 text-primary"></i>
                <h3 class="mb-2 text-lg font-bold">Os melhores imóveis</h3>
                <p class="text-gray-600">Escolha entre apartamentos, casas, salas... Considere uma visita com um dos
                    nossos corretores.</p>
            </div>
            <div class="flex flex-col items-center p-6 text-center bg-white rounded-xl shadow-lg">
                <i data-lucide="user-check" class="mb-2 w-8 h-8 text-primary"></i>
                <h3 class="mb-2 text-lg font-bold">Vamos acompanhar você</h3>
                <p class="text-gray-600">Oferecemos a você a melhor consultoria na escolha do seu imóvel, da escolha da
                    localização, tipo e características.</p>
            </div>
            <div class="flex flex-col items-center p-6 text-center bg-white rounded-xl shadow-lg">
                <i data-lucide="thumbs-up" class="mb-2 w-8 h-8 text-primary"></i>
                <h3 class="mb-2 text-lg font-bold">Sempre a melhor condição</h3>
                <p class="text-gray-600">Nossa equipe irá buscar a melhor condição de financiamento, oferecendo
                    consultoria no fechamento do imóvel.</p>
            </div>
        </div>
    </section>
    <!-- Featured Properties Section -->
    <section id="featured" class="py-16 md:py-24">
        <div class="container px-4 mx-auto">
            <div class="mb-12 text-center">
                <h2 class="text-3xl font-bold text-gray-800 md:text-4xl">Imóveis em Destaque</h2>
                <p class="mt-2 text-lg text-gray-600">Confira as melhores oportunidades que selecionamos para você.</p>
            </div>
            <!-- Bento Grid Start -->
            <div class="grid gap-8 md:grid-cols-4 bento-grid">
                @if (count($imovelCards) >= 6)
                <!-- Primeira linha: 1 largo, 2 estreitos -->
                <div class="md:col-span-2 bento-card">
                    @livewire('imovel-card', ['imovel' => $imovelCards[0]])
                </div>
                <div class="md:col-span-1 bento-card">
                    @livewire('imovel-card', ['imovel' => $imovelCards[1]])
                </div>
                <div class="md:col-span-1 bento-card">
                    @livewire('imovel-card', ['imovel' => $imovelCards[2]])
                </div>
                <!-- Segunda linha: 2 estreitos, 1 largo -->
                <div class="md:col-span-1 bento-card">
                    @livewire('imovel-card', ['imovel' => $imovelCards[3]])
                </div>
                <div class="md:col-span-1 bento-card">
                    @livewire('imovel-card', ['imovel' => $imovelCards[4]])
                </div>
                <div class="md:col-span-2 bento-card">
                    @livewire('imovel-card', ['imovel' => $imovelCards[5]])
                </div>
                @else
                <!-- Grid adaptável para menos de 6 cards -->
                @foreach ($imovelCards as $index => $card)
                <div class="md:col-span-{{ $index === 0 || $index === 5 ? '2' : '1' }} bento-card">
                    @livewire('imovel-card', ['imovel' => $card])
                </div>
                @endforeach
                @endif
            </div>
            <!-- Bento Grid End -->
        </div>
    </section>
    <!-- Filter Chips Section -->
    <section class="py-12 bg-white">
        <div class="container px-4 mx-auto">
            <h2 class="mb-4 text-2xl font-bold text-gray-800">+ de {{ $imovelCount - 1 }} Imóveis</h2>
            <p class="mb-6 text-gray-600">Para Comprar ou Alugar, são várias opções de escolha em diversos bairros</p>
            <div class="flex flex-wrap gap-3">

                @foreach ($imoveisDisponiveis as $imovel)
                <a href="/imovel/{{$imovel->id}}" class="cursor-pointer">
                    <span class="px-4 py-2 rounded-full bg-secondary text-white font-semibold hover:bg-primary inline-block cursor-pointer">
                        {{ $imovel->titulo }}
                    </span>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Imóveis por Bairro Section -->
    <!-- <section class="py-12 bg-gray-50">
        <div class="container px-4 mx-auto">
            <h2 class="mb-8 text-2xl font-bold text-gray-800">Imóveis disponíveis por bairro</h2>
            <div class="grid grid-cols-2 gap-6 md:grid-cols-3 lg:grid-cols-6">
                <div class="flex flex-col items-center p-4 bg-white rounded-xl shadow">
                    <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=400&auto=format&fit=crop"
                        alt="Centro" class="object-cover mb-2 w-24 h-24 rounded-lg">
                    <span class="font-bold text-gray-800">Centro</span>
                    <span class="text-sm font-semibold text-primary">31 imóveis</span>
                </div>
                <div class="flex flex-col items-center p-4 bg-white rounded-xl shadow">
                    <img src="https://images.unsplash.com/photo-1464983953574-0892a716854b?q=80&w=400&auto=format&fit=crop"
                        alt="Flexeiras" class="object-cover mb-2 w-24 h-24 rounded-lg">
                    <span class="font-bold text-gray-800">Flexeiras</span>
                    <span class="text-sm font-semibold text-primary">17 imóveis</span>
                </div>
                <div class="flex flex-col items-center p-4 bg-white rounded-xl shadow">
                    <img src="https://images.unsplash.com/photo-1507089947368-19c1da9775ae?q=80&w=400&auto=format&fit=crop"
                        alt="Barbuda" class="object-cover mb-2 w-24 h-24 rounded-lg">
                    <span class="font-bold text-gray-800">Barbuda</span>
                    <span class="text-sm font-semibold text-primary">8 imóveis</span>
                </div>
                <div class="flex flex-col items-center p-4 bg-white rounded-xl shadow">
                    <img src="https://images.unsplash.com/photo-1512918728675-ed5a9ecdebfd?q=80&w=400&auto=format&fit=crop"
                        alt="Nova Marília" class="object-cover mb-2 w-24 h-24 rounded-lg">
                    <span class="font-bold text-gray-800">Nova Marília</span>
                    <span class="text-sm font-semibold text-primary">4 imóveis</span>
                </div>
                <div class="flex flex-col items-center p-4 bg-white rounded-xl shadow">
                    <img src="https://images.unsplash.com/photo-1465101046530-73398c7f28ca?q=80&w=400&auto=format&fit=crop"
                        alt="Figueira" class="object-cover mb-2 w-24 h-24 rounded-lg">
                    <span class="font-bold text-gray-800">Figueira</span>
                    <span class="text-sm font-semibold text-primary">6 imóveis</span>
                </div>
                <div class="flex flex-col items-center p-4 bg-white rounded-xl shadow">
                    <img src="https://images.unsplash.com/photo-1465101178521-c1a9136a3fd9?q=80&w=400&auto=format&fit=crop"
                        alt="Piedade" class="object-cover mb-2 w-24 h-24 rounded-lg">
                    <span class="font-bold text-gray-800">Piedade</span>
                    <span class="text-sm font-semibold text-primary">5 imóveis</span>
                </div>
            </div>
        </div>
    </section> -->

    <section class="py-12 bg-white">
        <div class="container px-4 mx-auto">
            <div class="flex flex-col md:flex-row items-center p-4 bg-white rounded-xl shadow gap-4">
                <div class="flex flex-col w-full md:w-1/2">
                    <p class="text-2xl font-bold text-gray-800 mb-4">Sobre nós</p>
                    <p class="text-gray-600 text-base leading-relaxed">Com mais de três décadas de sólida experiência no mercado imobiliário, Marcos Pieroni, fundador da reconhecida McFlats, lidera agora um novo projeto que nasce da tradição, mas olha para o futuro: uma empresa voltada à curadoria de imóveis exclusivos, sofisticados e com alto padrão de qualidade. </p>
                    <br>
                    <p class="text-gray-600 text-base leading-relaxed"> Desde 1992, Marcos esteve à frente da McFlats, referência na compra, venda, locação e administração de flats em localizações nobres do Rio de Janeiro. Ao longo dessa trajetória, consolidou sua expertise também em consultoria para investimentos imobiliários, tanto no Brasil quanto no exterior — através da Next Consulting, com atuação no Rio de Janeiro e em Milão. </p>
                    <br>

                    <p class="text-gray-600 text-base leading-relaxed"> Agora, com uma visão ainda mais aprimorada e um olhar atento às exigências do mercado de alto padrão, este projeto tem como missão oferecer imóveis únicos, atendimento personalizado e experiências residenciais incomparáveis. Aqui, cada imóvel é escolhido com critério, cada cliente é atendido com exclusividade, e cada detalhe é pensado para proporcionar luxo, conforto e confiança.</p>
                </div>
                <div class="flex flex-col w-full md:w-1/2">
                    <div class="relative w-full h-0 pb-[56.25%]">
                        <iframe
                            class="absolute top-0 left-0 w-full h-full rounded-lg"
                            src="https://www.youtube.com/embed/CEGr2_p6haA?si=2Y19fzaFpVvySfQc"
                            title="YouTube video player"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin"
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Loan Simulator Section -->
    {{-- <livewire:loan-simulator />  --}}

    {{--
    <section id="agents" class="py-16 md:py-24">
        <div class="container px-4 mx-auto">
            <div class="mb-12 text-center">
                <h2 class="text-3xl font-bold text-gray-800 md:text-4xl">Nossos Corretores</h2>
                <p class="mt-2 text-lg text-gray-600">Uma equipe de especialistas pronta para te atender.</p>
            </div>
            <div class="relative">
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse ($corretores as $corretor)
                    <div class="p-8 text-center bg-white rounded-xl shadow-lg transition-shadow duration-300 hover:shadow-xl group">
                        <img src="{{ 'storage/' . $corretor->foto ?? 'https://placehold.co/128x128/EFEFEF/777777?text=Foto' }}"
    alt="Corretor {{ $corretor->name }}"
    class="mx-auto mb-4 w-32 h-32 rounded-full border-4 border-white transition-colors duration-300 group-hover:border-primary">
    <h3 class="text-xl font-bold text-gray-800">{{ $corretor->name }} </h3>
    <p class="mb-4 font-semibold text-primary">{{ $corretor->creci }}</p>
    <p class="mb-4 text-gray-600">{{ $corretor->descricao }}</p>
    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $corretor->celular) }}" target="_blank"
        class="inline-flex items-center px-6 py-2 font-semibold text-white bg-green-500 rounded-lg transition hover:bg-green-600">
        <x-whatsapp />
        WhatsApp
    </a>
    </div>
    @empty
    <div class="col-span-3 p-8 text-center">
        <p class="text-gray-600">Nenhum corretor cadastrado no momento.</p>
    </div>
    @endforelse
    </div>
    {{-- <button
                    class="absolute left-0 top-1/2 p-2 bg-white rounded-full border border-gray-300 shadow transition -translate-y-1/2 hover:bg-primary hover:text-white lg:-left-12"
                    aria-label="Anterior"><i data-lucide="arrow-left"></i></button>
                <button
                    class="absolute right-0 top-1/2 p-2 bg-white rounded-full border border-gray-300 shadow transition -translate-y-1/2 hover:bg-primary hover:text-white lg:-right-12"
                    aria-label="Próximo"><i data-lucide="arrow-right"></i></button> --}}
    </div>
    </div>
    </section>
    --}}
</main>