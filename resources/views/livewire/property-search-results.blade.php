@extends('layouts.site')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="container flex flex-col gap-8 px-4 py-8 mx-auto lg:flex-row">
        <!-- Sidebar Filters -->
        <aside class="p-6 mb-8 w-full bg-white rounded-xl shadow lg:w-64 lg:mb-0">
            <h2 class="mb-4 text-lg font-bold">Filtrar</h2>
            <form class="space-y-6">
                <div>
                    <label class="block mb-2 text-sm font-semibold">Cidade ou bairro</label>
                    <input type="text" class="px-4 py-2 w-full bg-gray-50 rounded-lg border-gray-200" placeholder="Ex: Magé, Centro">
                </div>
                <div>
                    <label class="block mb-2 text-sm font-semibold">Tipo do imóvel</label>
                    <select class="px-4 py-2 w-full bg-gray-50 rounded-lg border-gray-200">
                        <option>Todos</option>
                        <option>Casa</option>
                        <option>Apartamento</option>
                        <option>Terreno</option>
                        <option>Comercial</option>
                    </select>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-semibold">Faixa de preço</label>
                    <div class="flex items-center space-x-2">
                        <input type="number" class="px-2 py-1 w-1/2 bg-gray-50 rounded-lg border-gray-200" placeholder="Mín">
                        <span>-</span>
                        <input type="number" class="px-2 py-1 w-1/2 bg-gray-50 rounded-lg border-gray-200" placeholder="Máx">
                    </div>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-semibold">Área útil (m²)</label>
                    <div class="flex items-center space-x-2">
                        <input type="number" class="px-2 py-1 w-1/2 bg-gray-50 rounded-lg border-gray-200" placeholder="Mín">
                        <span>-</span>
                        <input type="number" class="px-2 py-1 w-1/2 bg-gray-50 rounded-lg border-gray-200" placeholder="Máx">
                    </div>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-semibold">Quartos</label>
                    <select class="px-4 py-2 w-full bg-gray-50 rounded-lg border-gray-200">
                        <option>Qualquer</option>
                        <option>1+</option>
                        <option>2+</option>
                        <option>3+</option>
                        <option>4+</option>
                    </select>
                </div>
                <button type="submit" class="py-2 mt-4 w-full font-semibold text-white rounded-lg bg-primary">Filtrar</button>
            </form>
        </aside>

        <!-- Main Content -->
        <main class="flex-1">
            <div class="flex flex-col gap-4 mb-6 md:flex-row md:items-center md:justify-between">
                <div class="text-sm text-gray-700">17 imóveis encontrados</div>
                <div class="flex gap-2 items-center">
                    <span class="text-sm text-gray-500">Exibir:</span>
                    <button class="p-2 rounded hover:bg-gray-200" title="Grade"><i data-lucide="grid" class="w-5 h-5"></i></button>
                    <button class="p-2 rounded hover:bg-gray-200" title="Lista"><i data-lucide="list" class="w-5 h-5"></i></button>
                    <span class="ml-4 text-sm text-gray-500">Ordenar por:</span>
                    <select class="px-2 py-1 text-sm bg-gray-50 rounded border-gray-200">
                        <option>Mais recentes</option>
                        <option>Menor preço</option>
                        <option>Maior preço</option>
                    </select>
                </div>
            </div>
            <!-- Property Cards Grid -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @for ($i = 0; $i < 12; $i++)
                <div class="flex overflow-hidden flex-col bg-white rounded-xl shadow transition hover:shadow-lg">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1580587771525-78b9dba3b914?q=80&w=400&auto=format&fit=crop" alt="Casa" class="object-cover w-full h-44">
                        <span class="absolute top-3 left-3 px-3 py-1 text-xs font-bold text-white rounded-full bg-primary">Destaque</span>
                        <span class="absolute top-3 right-3 p-1 bg-white rounded-full border text-primary border-primary"><i data-lucide="heart" class="w-5 h-5"></i></span>
                    </div>
                    <div class="flex flex-col flex-1 p-4">
                        <div class="flex gap-2 items-center mb-2">
                            <span class="text-xs text-gray-500">Locação</span>
                            <span class="text-xs text-gray-400">•</span>
                            <span class="text-xs text-gray-500">Centro - Magé</span>
                        </div>
                        <h3 class="mb-1 text-lg font-bold">Linda casa centro - Magé</h3>
                        <div class="mb-2 text-xl font-bold text-primary">R$ 1.000 /mês</div>
                        <div class="flex gap-4 items-center mb-4 text-sm text-gray-600">
                            <span class="flex gap-1 items-center"><i data-lucide="bed-double" class="w-4 h-4"></i> 2</span>
                            <span class="flex gap-1 items-center"><i data-lucide="bath" class="w-4 h-4"></i> 1</span>
                            <span class="flex gap-1 items-center"><i data-lucide="ruler" class="w-4 h-4"></i> 80m²</span>
                        </div>
                        <div class="flex gap-2 mt-auto">
                            <button class="flex-1 py-2 font-semibold rounded-lg border transition border-primary text-primary hover:bg-primary hover:text-white">Ver detalhes</button>
                            <button class="flex-1 py-2 font-semibold rounded-lg border transition border-primary text-primary hover:bg-primary hover:text-white">Contato</button>
                        </div>
                    </div>
                    <div class="flex items-center p-4 border-t border-gray-100">
                        <img src="https://placehold.co/32x32/EFEFEF/777777?text=BR" alt="Corretor" class="mr-2 w-8 h-8 rounded-full">
                        <span class="text-xs text-gray-700">Bruna Rocha</span>
                    </div>
                </div>
                @endfor
            </div>
            <!-- Pagination -->
            <div class="flex justify-center mt-8">
                <nav class="inline-flex -space-x-px">
                    <a href="#" class="px-3 py-2 text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100">&laquo;</a>
                    <a href="#" class="px-3 py-2 font-bold bg-white border border-gray-300 text-primary">1</a>
                    <a href="#" class="px-3 py-2 text-gray-700 bg-white border border-gray-300 hover:bg-gray-100">2</a>
                    <a href="#" class="px-3 py-2 text-gray-700 bg-white border border-gray-300 hover:bg-gray-100">3</a>
                    <a href="#" class="px-3 py-2 text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100">&raquo;</a>
                </nav>
            </div>
        </main>
    </div>
</div>

<!-- Footer -->
<footer class="mt-16 text-white bg-gray-800">
    <div class="container grid grid-cols-1 gap-8 px-4 py-12 mx-auto md:grid-cols-4">
        <div>
            <div class="flex items-center mb-4 space-x-2">
                <span class="flex justify-center items-center w-10 h-10 text-2xl font-bold text-white rounded-md bg-primary">BR</span>
                <span class="text-xl font-bold">Bruna Rocha</span>
            </div>
            <p class="text-sm text-gray-400">Especializada em venda e locação de imóveis residenciais e comerciais na cidade de Magé e região.</p>
        </div>
        <div>
            <h5 class="mb-4 font-semibold">Empresa</h5>
            <ul class="space-y-2 text-sm text-gray-400">
                <li><a href="#">Sobre</a></li>
                <li><a href="#">Contato</a></li>
            </ul>
        </div>
        <div>
            <h5 class="mb-4 font-semibold">Serviços</h5>
            <ul class="space-y-2 text-sm text-gray-400">
                <li><a href="#">Venda</a></li>
                <li><a href="#">Locação</a></li>
            </ul>
        </div>
        <div>
            <h5 class="mb-4 font-semibold">Imóveis</h5>
            <ul class="space-y-2 text-sm text-gray-400">
                <li><a href="#">Casas</a></li>
                <li><a href="#">Apartamentos</a></li>
                <li><a href="#">Terrenos</a></li>
            </ul>
        </div>
    </div>
    <div class="py-6 text-xs text-center text-gray-400 border-t border-gray-700">
        &copy; 2024 Bruna Rocha Imóveis. Todos os direitos reservados. Feito com <span class="text-primary">♥</span> por Imobzi
    </div>
</footer>
@endsection
