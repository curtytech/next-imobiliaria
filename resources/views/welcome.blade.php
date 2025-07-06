@extends('layouts.site')

@section('content')
    <!-- Header -->
    <header class="sticky top-0 z-40 bg-white shadow-sm">
        <div class="container px-4 mx-auto">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <a href="#" class="flex items-center space-x-2">
                    <span class="flex justify-center items-center w-10 h-10 text-2xl font-bold text-white rounded-md bg-primary">NX</span>
                    <span class="hidden text-xl font-bold text-gray-800 sm:block">Next Imobiliária</span>
                </a>
                <!-- Desktop Navigation -->
                <nav class="hidden items-center space-x-6 lg:flex">
                    <a href="#featured" class="text-gray-600 transition hover:text-primary">Destaques</a>
                    <a href="#search" class="text-gray-600 transition hover:text-primary">Buscar Imóvel</a>
                    <a href="#simulator" class="text-gray-600 transition hover:text-primary">Simulador</a>
                    <a href="#agents" class="text-gray-600 transition hover:text-primary">Corretores</a>
                    <a href="#contact" class="px-4 py-2 text-white rounded-lg shadow-sm transition bg-primary hover:bg-primary-dark">Fale Conosco</a>
                    <a href="#" class="px-4 py-2 ml-4 font-semibold text-white rounded-lg shadow-sm transition bg-primary hover:bg-primary-dark">Anuncie seu imóvel</a>
                </nav>
                <!-- Mobile Menu Button -->
                <div class="lg:hidden">
                    <button class="text-gray-700 focus:outline-none">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>
    <main>
        <!-- Hero Section -->
        <section id="hero" class="relative min-h-[70vh] md:min-h-[80vh] flex items-center justify-center text-white">
            <div class="absolute inset-0 z-0 bg-center bg-no-repeat bg-cover" style="background-image: url('https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?q=80&w=2070&auto=format&fit=crop');">
                <div class="absolute inset-0 bg-black/50"></div>
            </div>
            <div class="relative z-10 px-4 text-center">
                <h1 class="mb-4 text-4xl font-extrabold drop-shadow-lg md:text-6xl">O seu imóvel dos sonhos em Magé</h1>
                <p class="mx-auto mb-8 max-w-3xl text-lg drop-shadow-md md:text-xl">Especializado em venda e locação de imóveis residenciais e comerciais na cidade de Magé.</p>
                @livewire('hero-search-form')
            </div>
        </section>
        <!-- Feature Highlights Section -->
        <section class="container relative z-20 px-4 mx-auto -mt-12 mb-12">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <div class="flex flex-col items-center p-6 text-center bg-white rounded-xl shadow-lg">
                    <i data-lucide="star" class="mb-2 w-8 h-8 text-primary"></i>
                    <h3 class="mb-2 text-lg font-bold">Os melhores imóveis</h3>
                    <p class="text-gray-600">Escolha entre apartamentos, casas, salas... Considere uma visita com um dos nossos corretores.</p>
                </div>
                <div class="flex flex-col items-center p-6 text-center bg-white rounded-xl shadow-lg">
                    <i data-lucide="user-check" class="mb-2 w-8 h-8 text-primary"></i>
                    <h3 class="mb-2 text-lg font-bold">Vamos acompanhar você</h3>
                    <p class="text-gray-600">Oferecemos a você a melhor consultoria na escolha do seu imóvel, da escolha da localização, tipo e características.</p>
                </div>
                <div class="flex flex-col items-center p-6 text-center bg-white rounded-xl shadow-lg">
                    <i data-lucide="thumbs-up" class="mb-2 w-8 h-8 text-primary"></i>
                    <h3 class="mb-2 text-lg font-bold">Sempre a melhor condição</h3>
                    <p class="text-gray-600">Nossa equipe irá buscar a melhor condição de financiamento, oferecendo consultoria no fechamento do imóvel.</p>
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
                <div class="featured-glide">
                    <div class="glide__track" data-glide-el="track">
                        <ul class="glide__slides">
                            <!-- Property Card 1 -->
                            <li class="glide__slide">
                                <div class="overflow-hidden bg-white rounded-xl shadow-lg transition-shadow duration-300 hover:shadow-2xl group">
                                    <div class="relative">
                                        <img src="https://images.unsplash.com/photo-1580587771525-78b9dba3b914?q=80&w=1974&auto=format&fit=crop" alt="Casa moderna com piscina" class="object-cover w-full h-56 transition-transform duration-300 group-hover:scale-105">
                                        <div class="absolute top-4 left-4 px-3 py-1 text-xs font-bold text-white rounded-full bg-primary">Exclusividade</div>
                                        <div class="absolute right-0 bottom-0 left-0 p-4 bg-gradient-to-t to-transparent from-black/70">
                                            <h3 class="text-xl font-bold text-white">Casa Moderna em Piabetá</h3>
                                            <p class="text-sm text-white/90">Rua das Flores, 123</p>
                                        </div>
                                    </div>
                                    <div class="p-6">
                                        <div class="flex justify-between items-center mb-4">
                                            <p class="text-2xl font-bold text-primary">R$ 750.000</p>
                                            <div class="flex space-x-4 text-gray-600">
                                                <span class="flex items-center space-x-1"><i data-lucide="bed-double" class="w-5 h-5"></i><span>3</span></span>
                                                <span class="flex items-center space-x-1"><i data-lucide="bath" class="w-5 h-5"></i><span>4</span></span>
                                                <span class="flex items-center space-x-1"><i data-lucide="ruler" class="w-5 h-5"></i><span>220 m²</span></span>
                                            </div>
                                        </div>
                                        <button class="py-3 w-full font-semibold text-white rounded-lg transition bg-primary hover:bg-primary-dark">Ver Detalhes</button>
                                    </div>
                                </div>
                            </li>
                            <!-- Property Card 2 -->
                            <li class="glide__slide">
                                <div class="overflow-hidden bg-white rounded-xl shadow-lg transition-shadow duration-300 hover:shadow-2xl group">
                                    <div class="relative">
                                        <img src="https://images.unsplash.com/photo-1570129477492-45c003edd2be?q=80&w=2070&auto=format&fit=crop" alt="Casa com jardim" class="object-cover w-full h-56 transition-transform duration-300 group-hover:scale-105">
                                        <div class="absolute top-4 left-4 px-3 py-1 text-xs font-bold text-white bg-green-600 rounded-full">Oportunidade</div>
                                        <div class="absolute right-0 bottom-0 left-0 p-4 bg-gradient-to-t to-transparent from-black/70">
                                            <h3 class="text-xl font-bold text-white">Apartamento Aconchegante</h3>
                                            <p class="text-sm text-white/90">Centro, Magé</p>
                                        </div>
                                    </div>
                                    <div class="p-6">
                                        <div class="flex justify-between items-center mb-4">
                                            <p class="text-2xl font-bold text-primary">R$ 320.000</p>
                                            <div class="flex space-x-4 text-gray-600">
                                                <span class="flex items-center space-x-1"><i data-lucide="bed-double" class="w-5 h-5"></i><span>2</span></span>
                                                <span class="flex items-center space-x-1"><i data-lucide="bath" class="w-5 h-5"></i><span>2</span></span>
                                                <span class="flex items-center space-x-1"><i data-lucide="ruler" class="w-5 h-5"></i><span>75 m²</span></span>
                                            </div>
                                        </div>
                                        <button class="py-3 w-full font-semibold text-white rounded-lg transition bg-primary hover:bg-primary-dark">Ver Detalhes</button>
                                    </div>
                                </div>
                            </li>
                            <!-- Property Card 3 -->
                            <li class="glide__slide">
                                <div class="overflow-hidden bg-white rounded-xl shadow-lg transition-shadow duration-300 hover:shadow-2xl group">
                                    <div class="relative">
                                        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=2070&auto=format&fit=crop" alt="Casa de luxo" class="object-cover w-full h-56 transition-transform duration-300 group-hover:scale-105">
                                        <div class="absolute top-4 left-4 px-3 py-1 text-xs font-bold text-white rounded-full bg-primary">Destaque</div>
                                        <div class="absolute right-0 bottom-0 left-0 p-4 bg-gradient-to-t to-transparent from-black/70">
                                            <h3 class="text-xl font-bold text-white">Sítio Espaçoso</h3>
                                            <p class="text-sm text-white/90">Zona Rural, Magé</p>
                                        </div>
                                    </div>
                                    <div class="p-6">
                                        <div class="flex justify-between items-center mb-4">
                                            <p class="text-2xl font-bold text-primary">R$ 1.200.000</p>
                                            <div class="flex space-x-4 text-gray-600">
                                                <span class="flex items-center space-x-1"><i data-lucide="bed-double" class="w-5 h-5"></i><span>5</span></span>
                                                <span class="flex items-center space-x-1"><i data-lucide="bath" class="w-5 h-5"></i><span>6</span></span>
                                                <span class="flex items-center space-x-1"><i data-lucide="ruler" class="w-5 h-5"></i><span>5000 m²</span></span>
                                            </div>
                                        </div>
                                        <button class="py-3 w-full font-semibold text-white rounded-lg transition bg-primary hover:bg-primary-dark">Ver Detalhes</button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="glide__arrows" data-glide-el="controls">
                        <button class="glide__arrow glide__arrow--left" data-glide-dir="<"><i data-lucide="arrow-left"></i></button>
                        <button class="glide__arrow glide__arrow--right" data-glide-dir=">"><i data-lucide="arrow-right"></i></button>
                    </div>
                </div>
            </div>
        </section>
        <!-- Filter Chips Section -->
        <section class="py-12 bg-white">
            <div class="container px-4 mx-auto">
                <h2 class="mb-4 text-2xl font-bold text-gray-800">+ de 171 Imóveis</h2>
                <p class="mb-6 text-gray-600">Para Comprar ou Alugar, são várias opções de escolha em diversos bairros</p>
                <div class="flex flex-wrap gap-3">
                    <button class="px-4 py-2 bg-gray-100 rounded-full transition hover:bg-primary hover:text-white">Casa à venda em Centro</button>
                    <button class="px-4 py-2 bg-gray-100 rounded-full transition hover:bg-primary hover:text-white">Apartamento à venda em Flexeiras</button>
                    <button class="px-4 py-2 bg-gray-100 rounded-full transition hover:bg-primary hover:text-white">Casa à venda em Barbuda</button>
                    <button class="px-4 py-2 bg-gray-100 rounded-full transition hover:bg-primary hover:text-white">Sítio à venda em Vale das Pedrinhas</button>
                    <button class="px-4 py-2 bg-gray-100 rounded-full transition hover:bg-primary hover:text-white">Casa à venda em Nova Marília</button>
                    <button class="px-4 py-2 bg-gray-100 rounded-full transition hover:bg-primary hover:text-white">Casa à venda em Cascata</button>
                    <button class="px-4 py-2 bg-gray-100 rounded-full transition hover:bg-primary hover:text-white">Apartamento à venda em Centro</button>
                    <button class="px-4 py-2 bg-gray-100 rounded-full transition hover:bg-primary hover:text-white">Terreno à venda em Flexeiras</button>
                    <button class="px-4 py-2 bg-gray-100 rounded-full transition hover:bg-primary hover:text-white">Loja/Comercial em Centro</button>
                </div>
            </div>
        </section>
        <!-- Imóveis por Bairro Section -->
        <section class="py-12 bg-gray-50">
            <div class="container px-4 mx-auto">
                <h2 class="mb-8 text-2xl font-bold text-gray-800">Imóveis disponíveis por bairro</h2>
                <div class="grid grid-cols-2 gap-6 md:grid-cols-3 lg:grid-cols-6">
                    <div class="flex flex-col items-center p-4 bg-white rounded-xl shadow">
                        <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=400&auto=format&fit=crop" alt="Centro" class="object-cover mb-2 w-24 h-24 rounded-lg">
                        <span class="font-bold text-gray-800">Centro</span>
                        <span class="text-sm font-semibold text-primary">31 imóveis</span>
                    </div>
                    <div class="flex flex-col items-center p-4 bg-white rounded-xl shadow">
                        <img src="https://images.unsplash.com/photo-1464983953574-0892a716854b?q=80&w=400&auto=format&fit=crop" alt="Flexeiras" class="object-cover mb-2 w-24 h-24 rounded-lg">
                        <span class="font-bold text-gray-800">Flexeiras</span>
                        <span class="text-sm font-semibold text-primary">17 imóveis</span>
                    </div>
                    <div class="flex flex-col items-center p-4 bg-white rounded-xl shadow">
                        <img src="https://images.unsplash.com/photo-1507089947368-19c1da9775ae?q=80&w=400&auto=format&fit=crop" alt="Barbuda" class="object-cover mb-2 w-24 h-24 rounded-lg">
                        <span class="font-bold text-gray-800">Barbuda</span>
                        <span class="text-sm font-semibold text-primary">8 imóveis</span>
                    </div>
                    <div class="flex flex-col items-center p-4 bg-white rounded-xl shadow">
                        <img src="https://images.unsplash.com/photo-1512918728675-ed5a9ecdebfd?q=80&w=400&auto=format&fit=crop" alt="Nova Marília" class="object-cover mb-2 w-24 h-24 rounded-lg">
                        <span class="font-bold text-gray-800">Nova Marília</span>
                        <span class="text-sm font-semibold text-primary">4 imóveis</span>
                    </div>
                    <div class="flex flex-col items-center p-4 bg-white rounded-xl shadow">
                        <img src="https://images.unsplash.com/photo-1465101046530-73398c7f28ca?q=80&w=400&auto=format&fit=crop" alt="Figueira" class="object-cover mb-2 w-24 h-24 rounded-lg">
                        <span class="font-bold text-gray-800">Figueira</span>
                        <span class="text-sm font-semibold text-primary">6 imóveis</span>
                    </div>
                    <div class="flex flex-col items-center p-4 bg-white rounded-xl shadow">
                        <img src="https://images.unsplash.com/photo-1465101178521-c1a9136a3fd9?q=80&w=400&auto=format&fit=crop" alt="Piedade" class="object-cover mb-2 w-24 h-24 rounded-lg">
                        <span class="font-bold text-gray-800">Piedade</span>
                        <span class="text-sm font-semibold text-primary">5 imóveis</span>
                    </div>
                </div>
            </div>
        </section>
        <!-- Loan Simulator Section -->
        <section id="simulator" class="py-16 bg-white md:py-24">
            <div class="container px-4 mx-auto">
                <div class="mb-12 text-center">
                    <h2 class="text-3xl font-bold text-gray-800 md:text-4xl">Simulador de Financiamento</h2>
                    <p class="mt-2 text-lg text-gray-600">Planeje a compra do seu imóvel com uma simulação rápida.</p>
                </div>
                <div class="p-8 mx-auto max-w-4xl bg-gray-50 rounded-2xl shadow-inner" x-data="loanSimulator">
                    <div class="grid grid-cols-1 gap-8 items-center md:grid-cols-2">
                        <!-- Sliders -->
                        <div>
                            <div class="mb-6">
                                <label for="propertyValue" class="block mb-2 font-semibold text-gray-700">Valor do Imóvel</label>
                                <input type="range" id="propertyValue" min="50000" max="2000000" step="10000" x-model.number="propertyValue">
                                <p class="mt-2 text-2xl font-bold text-center text-primary" x-text="formatCurrency(propertyValue)"></p>
                            </div>
                            <div class="mb-6">
                                <label for="downPayment" class="block mb-2 font-semibold text-gray-700">Valor da Entrada</label>
                                <input type="range" id="downPayment" min="10000" max="1000000" step="5000" x-model.number="downPayment">
                                <p class="mt-2 text-2xl font-bold text-center text-primary" x-text="formatCurrency(downPayment)"></p>
                            </div>
                            <div>
                                <label for="loanTerm" class="block mb-2 font-semibold text-gray-700">Prazo (em anos)</label>
                                <input type="range" id="loanTerm" min="5" max="35" step="1" x-model.number="loanTerm">
                                <p class="mt-2 text-2xl font-bold text-center text-primary" x-text="loanTerm + ' anos'"></p>
                            </div>
                        </div>
                        <!-- Results -->
                        <div class="p-8 text-center bg-white rounded-xl border-2 shadow-lg border-primary">
                            <p class="mb-2 text-gray-600">Valor da Parcela Mensal</p>
                            <p class="mb-4 text-4xl font-extrabold text-gray-800 md:text-5xl" x-text="formatCurrency(monthlyPayment)"></p>
                            <p class="text-sm text-gray-500">Taxa de juros estimada: <span x-text="(interestRate * 100).toFixed(1)"></span>% a.a.</p>
                            <button class="py-3 mt-6 w-full font-semibold text-white rounded-lg shadow-md transition bg-primary hover:bg-primary-dark">Buscar imóveis nesta faixa</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Agents Section -->
        <section id="agents" class="py-16 md:py-24">
            <div class="container px-4 mx-auto">
                <div class="mb-12 text-center">
                    <h2 class="text-3xl font-bold text-gray-800 md:text-4xl">Nossos Corretores</h2>
                    <p class="mt-2 text-lg text-gray-600">Uma equipe de especialistas pronta para te atender.</p>
                </div>
                <div class="relative">
                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        <!-- Agent Card 1 -->
                        <div class="p-8 text-center bg-white rounded-xl shadow-lg transition-shadow duration-300 hover:shadow-xl group">
                            <img src="https://placehold.co/128x128/EFEFEF/777777?text=Foto" alt="Corretora Bruna Rocha" class="mx-auto mb-4 w-32 h-32 rounded-full border-4 border-white transition-colors duration-300 group-hover:border-primary">
                            <h3 class="text-xl font-bold text-gray-800">Bruna Rocha</h3>
                            <p class="mb-4 font-semibold text-primary">CRECI-RJ 12345</p>
                            <p class="mb-4 text-gray-600">Fundadora e especialista em imóveis de alto padrão. Paixão por realizar sonhos.</p>
                            <a href="#" class="inline-block px-6 py-2 font-semibold text-white bg-green-500 rounded-lg transition hover:bg-green-600">
                                <i data-lucide="message-circle" class="inline-block mr-2 w-5 h-5"></i>WhatsApp
                            </a>
                        </div>
                        <!-- Agent Card 2 -->
                        <div class="p-8 text-center bg-white rounded-xl shadow-lg transition-shadow duration-300 hover:shadow-xl group">
                            <img src="https://placehold.co/128x128/EFEFEF/777777?text=Foto" alt="Corretor Carlos Silva" class="mx-auto mb-4 w-32 h-32 rounded-full border-4 border-white transition-colors duration-300 group-hover:border-primary">
                            <h3 class="text-xl font-bold text-gray-800">Carlos Silva</h3>
                            <p class="mb-4 font-semibold text-primary">CRECI-RJ 67890</p>
                            <p class="mb-4 text-gray-600">Especialista em locações e novos empreendimentos. Agilidade é seu sobrenome.</p>
                            <a href="#" class="inline-block px-6 py-2 font-semibold text-white bg-green-500 rounded-lg transition hover:bg-green-600">
                                <i data-lucide="message-circle" class="inline-block mr-2 w-5 h-5"></i>WhatsApp
                            </a>
                        </div>
                        <!-- Agent Card 3 -->
                        <div class="p-8 text-center bg-white rounded-xl shadow-lg transition-shadow duration-300 hover:shadow-xl group">
                            <img src="https://placehold.co/128x128/EFEFEF/777777?text=Foto" alt="Corretora Ana Pereira" class="mx-auto mb-4 w-32 h-32 rounded-full border-4 border-white transition-colors duration-300 group-hover:border-primary">
                            <h3 class="text-xl font-bold text-gray-800">Ana Pereira</h3>
                            <p class="mb-4 font-semibold text-primary">CRECI-RJ 24680</p>
                            <p class="mb-4 text-gray-600">Focada em terrenos e oportunidades de investimento na região de Magé.</p>
                            <a href="#" class="inline-block px-6 py-2 font-semibold text-white bg-green-500 rounded-lg transition hover:bg-green-600">
                                <i data-lucide="message-circle" class="inline-block mr-2 w-5 h-5"></i>WhatsApp
                            </a>
                        </div>
                    </div>
                    <!-- Carousel Navigation -->
                    <button class="absolute left-0 top-1/2 p-2 bg-white rounded-full border border-gray-300 shadow transition -translate-y-1/2 hover:bg-primary hover:text-white lg:-left-12" aria-label="Anterior"><i data-lucide="arrow-left"></i></button>
                    <button class="absolute right-0 top-1/2 p-2 bg-white rounded-full border border-gray-300 shadow transition -translate-y-1/2 hover:bg-primary hover:text-white lg:-right-12" aria-label="Próximo"><i data-lucide="arrow-right"></i></button>
                </div>
            </div>
        </section>
    </main>
@endsection
