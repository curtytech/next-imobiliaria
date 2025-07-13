<?php

use function Livewire\Volt\{state, mount, computed};
use App\Models\Imovel;

state([
    'location' => '',
    'propertyType' => '',
    'priceMin' => '',
    'priceMax' => '',
    'areaMin' => '',
    'areaMax' => '',
    'bedrooms' => '',
    'bathrooms' => '',
    'viewMode' => 'grid',
    'sortBy' => 'recent',
    'propertiesFound' => 0,
    'currentPage' => 1,
    'perPage' => 12
]);

mount(function() {
    // Receber parâmetros da URL
    $this->location = request()->get('location', '');
    $this->propertyType = request()->get('propertyType', '');
    $this->loadProperties();
});

$loadProperties = function() {
    $query = Imovel::query()->where('status', 'disponivel');

    // Filtro por localização (cidade, bairro)
    if ($this->location) {
        $query->where(function($q) {
            $q->where('cidade', 'like', '%' . $this->location . '%')
              ->orWhere('bairro', 'like', '%' . $this->location . '%')
              ->orWhere('endereco', 'like', '%' . $this->location . '%');
        });
    }

    // Filtro por tipo de imóvel
    if ($this->propertyType) {
        $query->where('tipo', $this->propertyType);
    }

    // Filtro por faixa de preço
    if ($this->priceMin) {
        $query->where('preco', '>=', $this->priceMin);
    }
    if ($this->priceMax) {
        $query->where('preco', '<=', $this->priceMax);
    }

    // Filtro por área
    if ($this->areaMin) {
        $query->where('area', '>=', $this->areaMin);
    }
    if ($this->areaMax) {
        $query->where('area', '<=', $this->areaMax);
    }

    // Filtro por quartos
    if ($this->bedrooms) {
        $query->where('quartos', '>=', $this->bedrooms);
    }

    // Filtro por banheiros
    if ($this->bathrooms) {
        $query->where('banheiros', '>=', $this->bathrooms);
    }

    match ($this->sortBy) {
        'price_asc' => $query->orderBy('preco', 'asc'),
        'price_desc' => $query->orderBy('preco', 'desc'),
        'recent' => $query->orderBy('created_at', 'desc'),
        default => $query->orderBy('created_at', 'desc'),
    }

    $this->propertiesFound = $query->count();
};

$properties = computed(function() {
    $query = Imovel::query()->where('status', 'disponivel');

    // Filtro por localização (cidade, bairro)
    if ($this->location) {
        $query->where(function($q) {
            $q->where('cidade', 'like', '%' . $this->location . '%')
              ->orWhere('bairro', 'like', '%' . $this->location . '%')
              ->orWhere('endereco', 'like', '%' . $this->location . '%');
        });
    }

    // Filtro por tipo de imóvel
    if ($this->propertyType) {
        $query->where('tipo', $this->propertyType);
    }

    // Filtro por faixa de preço
    if ($this->priceMin) {
        $query->where('preco', '>=', $this->priceMin);
    }
    if ($this->priceMax) {
        $query->where('preco', '<=', $this->priceMax);
    }

    // Filtro por área
    if ($this->areaMin) {
        $query->where('area', '>=', $this->areaMin);
    }
    if ($this->areaMax) {
        $query->where('area', '<=', $this->areaMax);
    }

    // Filtro por quartos
    if ($this->bedrooms) {
        $query->where('quartos', '>=', $this->bedrooms);
    }

    // Filtro por banheiros
    if ($this->bathrooms) {
        $query->where('banheiros', '>=', $this->bathrooms);
    }

    match ($this->sortBy) {
        'price_asc' => $query->orderBy('preco', 'asc'),
        'price_desc' => $query->orderBy('preco', 'desc'),
        'recent' => $query->orderBy('created_at', 'desc'),
        default => $query->orderBy('created_at', 'desc'),
    };

    return $query->paginate($this->perPage);
});

$filter = function() {
    $this->currentPage = 1;
    $this->loadProperties();
};

$setViewMode = function($mode) {
    $this->viewMode = $mode;
};

$setSortBy = function($sort) {
    $this->sortBy = $sort;
    $this->loadProperties();
};

$clearFilters = function() {
    $this->location = '';
    $this->propertyType = '';
    $this->priceMin = '';
    $this->priceMax = '';
    $this->areaMin = '';
    $this->areaMax = '';
    $this->bedrooms = '';
    $this->bathrooms = '';
    $this->currentPage = 1;
    $this->loadProperties();
};

?>

<main>
    <div class="min-h-screen bg-gray-50">
        <div class="container flex flex-col gap-8 px-4 py-8 mx-auto lg:flex-row">
            <!-- Sidebar Filters -->
            <aside class="p-6 mb-8 w-full bg-white rounded-xl shadow lg:w-64 lg:mb-0">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold">Filtrar</h2>
                    <button wire:click="clearFilters" class="text-sm text-primary hover:underline">Limpar</button>
                </div>
                <form wire:submit.prevent="filter" class="space-y-6">
                    <div>
                        <label class="block mb-2 text-sm font-semibold">Cidade ou bairro</label>
                        <input type="text" wire:model.live="location"
                            class="px-4 py-2 w-full bg-gray-50 rounded-lg border-gray-200"
                            placeholder="Ex: Magé, Centro">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold">Tipo do imóvel</label>
                        <select wire:model.live="propertyType"
                            class="px-4 py-2 w-full bg-gray-50 rounded-lg border-gray-200">
                            <option value="">Todos</option>
                            <option value="casa">Casa</option>
                            <option value="apartamento">Apartamento</option>
                            <option value="terreno">Terreno</option>
                            <option value="comercial">Comercial</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold">Faixa de preço</label>
                        <div class="flex items-center space-x-2">
                            <input type="number" wire:model.live="priceMin"
                                class="px-2 py-1 w-1/2 bg-gray-50 rounded-lg border-gray-200" placeholder="Mín">
                            <span>-</span>
                            <input type="number" wire:model.live="priceMax"
                                class="px-2 py-1 w-1/2 bg-gray-50 rounded-lg border-gray-200" placeholder="Máx">
                        </div>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold">Área (m²)</label>
                        <div class="flex items-center space-x-2">
                            <input type="number" wire:model.live="areaMin"
                                class="px-2 py-1 w-1/2 bg-gray-50 rounded-lg border-gray-200" placeholder="Mín">
                            <span>-</span>
                            <input type="number" wire:model.live="areaMax"
                                class="px-2 py-1 w-1/2 bg-gray-50 rounded-lg border-gray-200" placeholder="Máx">
                        </div>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold">Quartos</label>
                        <select wire:model.live="bedrooms"
                            class="px-4 py-2 w-full bg-gray-50 rounded-lg border-gray-200">
                            <option value="">Qualquer</option>
                            <option value="1">1+</option>
                            <option value="2">2+</option>
                            <option value="3">3+</option>
                            <option value="4">4+</option>
                            <option value="5">5+</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold">Banheiros</label>
                        <select wire:model.live="bathrooms"
                            class="px-4 py-2 w-full bg-gray-50 rounded-lg border-gray-200">
                            <option value="">Qualquer</option>
                            <option value="1">1+</option>
                            <option value="2">2+</option>
                            <option value="3">3+</option>
                            <option value="4">4+</option>
                        </select>
                    </div>
                </form>
            </aside>

            <!-- Main Content -->
            <main class="flex-1">
                <div class="flex flex-col gap-4 mb-6 md:flex-row md:items-center md:justify-between">
                    <div class="text-sm text-gray-700">{{ $propertiesFound }} imóveis encontrados</div>
                    <div class="flex gap-2 items-center">
                        <span class="text-sm text-gray-500">Exibir:</span>
                        <button wire:click="setViewMode('grid')"
                            class="p-2 rounded hover:bg-gray-200 {{ $viewMode === 'grid' ? 'bg-gray-200' : '' }}"
                            title="Grade">
                            <x-lucide-grid class="w-5 h-5" />
                        </button>
                        <button wire:click="setViewMode('list')"
                            class="p-2 rounded hover:bg-gray-200 {{ $viewMode === 'list' ? 'bg-gray-200' : '' }}"
                            title="Lista">
                            <x-lucide-list class="w-5 h-5" />
                        </button>
                        <span class="ml-4 text-sm text-gray-500">Ordenar por:</span>
                        <select wire:model.live="sortBy" class="px-2 py-1 text-sm bg-gray-50 rounded border-gray-200">
                            <option value="recent">Mais recentes</option>
                            <option value="price_asc">Menor preço</option>
                            <option value="price_desc">Maior preço</option>
                        </select>
                    </div>
                </div>

                <!-- Property Cards Grid -->
                @if ($this->properties->count() > 0)
                    <div
                        class="grid grid-cols-1 gap-6 {{ $viewMode === 'grid' ? 'sm:grid-cols-2 lg:grid-cols-3' : 'grid-cols-1' }}">
                        @foreach ($this->properties as $imovel)
                            <div
                                class="flex overflow-hidden flex-col bg-white rounded-xl shadow transition hover:shadow-lg">
                                <div class="relative">
                                    @if ($imovel->fotos && count($imovel->fotos) > 0)
                                        <img src="{{ $imovel->fotos[0] }}" alt="{{ $imovel->titulo }}"
                                            class="object-cover w-full h-44">
                                    @else
                                        <img src="https://images.unsplash.com/photo-1580587771525-78b9dba3b914?q=80&w=400&auto=format&fit=crop"
                                            alt="{{ $imovel->titulo }}" class="object-cover w-full h-44">
                                    @endif
                                    @if ($imovel->destaque)
                                        <span
                                            class="absolute top-3 left-3 px-3 py-1 text-xs font-bold text-white rounded-full bg-primary">Destaque</span>
                                    @endif
                                    <span
                                        class="absolute top-3 right-3 p-1 bg-white rounded-full border text-primary border-primary">
                                        <x-lucide-heart class="w-5 h-5" />
                                    </span>
                                </div>
                                <div class="flex flex-col flex-1 p-4">
                                    <div class="flex gap-2 items-center mb-2">
                                        <span class="text-xs text-gray-500">{{ ucfirst($imovel->tipo) }}</span>
                                        <span class="text-xs text-gray-400">•</span>
                                        <span class="text-xs text-gray-500">{{ $imovel->bairro }} -
                                            {{ $imovel->cidade }}</span>
                                    </div>
                                    <h3 class="mb-1 text-lg font-bold">{{ $imovel->titulo }}</h3>
                                    <div class="mb-2 text-xl font-bold text-primary">{{ $imovel->preco_formatado }}
                                    </div>
                                    <div class="flex gap-4 items-center mb-4 text-sm text-gray-600">
                                        @if ($imovel->quartos)
                                            <span class="flex gap-1 items-center">
                                                <x-lucide-bed-double class="w-4 h-4" /> {{ $imovel->quartos }} Quartos
                                            </span>
                                        @endif
                                        @if ($imovel->banheiros)
                                            <span class="flex gap-1 items-center">
                                                <x-lucide-bath class="w-4 h-4" /> {{ $imovel->banheiros }}
                                                Banheiro{{ $imovel->banheiros > 1 ? 's' : '' }}
                                            </span>
                                        @endif
                                        <span class="flex gap-1 items-center">
                                            <x-lucide-ruler class="w-4 h-4" /> {{ $imovel->area }}m²
                                        </span>
                                    </div>
                                    <div class="flex gap-2 mt-auto">
                                        <button
                                            class="flex-1 py-2 font-semibold rounded-lg border transition border-primary text-primary hover:bg-primary hover:text-white">
                                            Ver detalhes
                                        </button>
                                        <button
                                            class="flex-1 py-2 font-semibold rounded-lg border transition border-primary text-primary hover:bg-primary hover:text-white">
                                            Contato
                                        </button>
                                    </div>
                                </div>
                                <div class="flex items-center p-4 border-t border-gray-100">
                                    <img src="https://placehold.co/32x32/EFEFEF/777777?text=BR" alt="Corretor"
                                        class="mr-2 w-8 h-8 rounded-full">
                                    <span class="text-xs text-gray-700">Corretor</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if ($this->properties->hasPages())
                        <div class="flex justify-center mt-8">
                            {{ $this->properties->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-12">
                        <x-lucide-search class="w-16 h-16 mx-auto text-gray-400 mb-4" />
                        <h3 class="text-lg font-semibold text-gray-600 mb-2">Nenhum imóvel encontrado</h3>
                        <p class="text-gray-500">Tente ajustar os filtros de busca para encontrar mais resultados.</p>
                    </div>
                @endif
            </main>
        </div>
    </div>
</main>
