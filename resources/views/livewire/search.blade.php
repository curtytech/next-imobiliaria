<?php

use function Livewire\Volt\{state, mount, computed, with};
use App\Models\Imovel;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

state([
    'location' => '',
    'propertyType' => '',
    'priceMin' => '',
    'priceMax' => '',
    'areaMin' => '',
    'areaMax' => '',
    'areaUtilMin' => '',
    'areaUtilMax' => '',
    'terrenoMin' => '',
    'terrenoMax' => '',
    'bedrooms' => '',
    'bathrooms' => '',
    'garageSpaces' => '',
    'neighborhood' => '',
    'cep' => '',
    'viewMode' => 'grid',
    'sortBy' => 'recent',
    'propertiesFound' => 0,
    'currentPage' => 1,
    'perPage' => 12,
    'loading' => false,
    'error' => null,
]);

mount(function () {
    try {
        // Receive URL parameters
        $this->location = request()->get('location', '');
        $this->propertyType = request()->get('propertyType', '');
        $this->priceMin = request()->get('priceMin', '');
        $this->priceMax = request()->get('priceMax', '');
        $this->areaMin = request()->get('areaMin', '');
        $this->areaMax = request()->get('areaMax', '');
        $this->areaUtilMin = request()->get('areaUtilMin', '');
        $this->areaUtilMax = request()->get('areaUtilMax', '');
        $this->terrenoMin = request()->get('terrenoMin', '');
        $this->terrenoMax = request()->get('terrenoMax', '');
        $this->bedrooms = request()->get('bedrooms', '');
        $this->bathrooms = request()->get('bathrooms', '');
        $this->garageSpaces = request()->get('garageSpaces', '');
        $this->neighborhood = request()->get('neighborhood', '');
        $this->cep = request()->get('cep', '');
        $this->loadProperties();
    } catch (\Exception $e) {
        Log::error('Error mounting property search component: ' . $e->getMessage());
        $this->error = 'Erro ao carregar a página. Tente novamente.';
    }
});

$buildQuery = function () {
    try {
        $query = Imovel::with(['tipoImovel', 'statusImovel', 'corretor'])
            ->whereHas('statusImovel', function($q) {
                $q->where('nome', 'Disponível');
            });

        // Location filter (city, neighborhood, address)
        if (!empty($this->location)) {
            $location = trim($this->location);
            $query->where(function ($q) use ($location) {
                $q->where('cidade', 'like', '%' . $location . '%')
                    ->orWhere('bairro', 'like', '%' . $location . '%')
                    ->orWhere('endereco', 'like', '%' . $location . '%');
            });
        }

        // Neighborhood filter
        if (!empty($this->neighborhood)) {
            $query->where('bairro', 'like', '%' . trim($this->neighborhood) . '%');
        }

        // CEP filter
        if (!empty($this->cep)) {
            $cepLimpo = preg_replace('/[^0-9]/', '', trim($this->cep));
            $query->where(function($q) use ($cepLimpo) {
                $q->where('cep', 'like', '%' . $cepLimpo . '%')
                  ->orWhereRaw('REPLACE(cep, "-", "") LIKE ?', ['%' . $cepLimpo . '%']);
            });
        }

        // Property type filter
        if (!empty($this->propertyType)) {
            $query->whereHas('tipoImovel', function($q) {
                $q->where('nome', 'like', '%' . $this->propertyType . '%');
            });
        }

        // Price range filter
        if (!empty($this->priceMin) && is_numeric($this->priceMin)) {
            $query->where('preco', '>=', (float) $this->priceMin);
        }
        if (!empty($this->priceMax) && is_numeric($this->priceMax)) {
            $query->where('preco', '<=', (float) $this->priceMax);
        }

        // Area filter
        if (!empty($this->areaMin) && is_numeric($this->areaMin)) {
            $query->where('area', '>=', (float) $this->areaMin);
        }
        if (!empty($this->areaMax) && is_numeric($this->areaMax)) {
            $query->where('area', '<=', (float) $this->areaMax);
        }

        // Useful area filter
        if (!empty($this->areaUtilMin) && is_numeric($this->areaUtilMin)) {
            $query->where('area_util', '>=', (float) $this->areaUtilMin);
        }
        if (!empty($this->areaUtilMax) && is_numeric($this->areaUtilMax)) {
            $query->where('area_util', '<=', (float) $this->areaUtilMax);
        }

        // Land area filter
        if (!empty($this->terrenoMin) && is_numeric($this->terrenoMin)) {
            $query->where('terreno', '>=', (float) $this->terrenoMin);
        }
        if (!empty($this->terrenoMax) && is_numeric($this->terrenoMax)) {
            $query->where('terreno', '<=', (float) $this->terrenoMax);
        }

        // Bedrooms filter
        if (!empty($this->bedrooms) && is_numeric($this->bedrooms)) {
            $query->where('quartos', '>=', (int) $this->bedrooms);
        }

        // Bathrooms filter
        if (!empty($this->bathrooms) && is_numeric($this->bathrooms)) {
            $query->where('banheiros', '>=', (int) $this->bathrooms);
        }

        // Garage spaces filter
        if (!empty($this->garageSpaces) && is_numeric($this->garageSpaces)) {
            $query->where('vagas_garagem', '>=', (int) $this->garageSpaces);
        }

        // Sorting
        match ($this->sortBy) {
            'price_asc' => $query->orderBy('preco', 'asc'),
            'price_desc' => $query->orderBy('preco', 'desc'),
            'recent' => $query->orderBy('created_at', 'desc'),
            default => $query->orderBy('created_at', 'desc'),
        };

        return $query;
    } catch (\Exception $e) {
        Log::error('Error building query: ' . $e->getMessage());
        throw $e;
    }
};

$loadProperties = function () {
    try {
        $this->loading = true;
        $this->error = null;

        $query = $this->buildQuery();
        $this->propertiesFound = $query->count();

        $this->loading = false;
    } catch (\Exception $e) {
        Log::error('Error loading properties: ' . $e->getMessage());
        $this->error = 'Erro ao carregar os imóveis. Tente novamente.';
        $this->loading = false;
        $this->propertiesFound = 0;
    }
};

$properties = computed(function () {
    try {
        $query = $this->buildQuery();
        return $query->paginate($this->perPage, ['*'], 'page', $this->currentPage);
    } catch (\Exception $e) {
        Log::error('Error computing properties: ' . $e->getMessage());
        // Return empty paginator in case of error
        return new LengthAwarePaginator([], 0, $this->perPage, $this->currentPage);
    }
});

$filter = function () {
    try {
        $this->currentPage = 1;
        $this->loadProperties();
    } catch (\Exception $e) {
        Log::error('Error filtering properties: ' . $e->getMessage());
        $this->error = 'Erro ao filtrar os imóveis. Tente novamente.';
    }
};

$setViewMode = function ($mode) {
    if (in_array($mode, ['grid', 'list'])) {
        $this->viewMode = $mode;
    }
};

$setSortBy = function ($sort) {
    try {
        $validSortOptions = ['recent', 'price_asc', 'price_desc'];
        if (in_array($sort, $validSortOptions)) {
            $this->sortBy = $sort;
            $this->currentPage = 1;
            $this->loadProperties();
        }
    } catch (\Exception $e) {
        Log::error('Error setting sort: ' . $e->getMessage());
        $this->error = 'Erro ao ordenar os imóveis. Tente novamente.';
    }
};

$clearFilters = function () {
    try {
        $this->location = '';
        $this->propertyType = '';
        $this->priceMin = '';
        $this->priceMax = '';
        $this->areaMin = '';
        $this->areaMax = '';
        $this->bedrooms = '';
        $this->bathrooms = '';
        $this->currentPage = 1;
        $this->error = null;
        $this->loadProperties();
    } catch (\Exception $e) {
        Log::error('Error clearing filters: ' . $e->getMessage());
        $this->error = 'Erro ao limpar filtros. Tente novamente.';
    }
};

$retryLoad = function () {
    $this->error = null;
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
                    <button wire:click="clearFilters" class="text-sm text-primary hover:underline"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="clearFilters">Limpar</span>
                        <span wire:loading wire:target="clearFilters">Limpando...</span>
                    </button>
                </div>

                <form wire:submit.prevent="filter" class="space-y-6">
                    <div>
                        <label class="block mb-2 text-sm font-semibold">Cidade ou bairro</label>
                        <input type="text" wire:model.live.debounce.500ms="location"
                            class="px-4 py-2 w-full bg-gray-50 rounded-lg border-gray-200 focus:border-primary focus:ring-1 focus:ring-primary"
                            placeholder="Ex: Magé, Centro">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold">Tipo do imóvel</label>
                        <select wire:model.live="propertyType"
                            class="px-4 py-2 w-full bg-gray-50 rounded-lg border-gray-200 focus:border-primary focus:ring-1 focus:ring-primary">
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
                            <input type="number" wire:model.live.debounce.500ms="priceMin" min="0"
                                class="px-2 py-1 w-1/2 bg-gray-50 rounded-lg border-gray-200 focus:border-primary focus:ring-1 focus:ring-primary"
                                placeholder="Mín">
                            <span>-</span>
                            <input type="number" wire:model.live.debounce.500ms="priceMax" min="0"
                                class="px-2 py-1 w-1/2 bg-gray-50 rounded-lg border-gray-200 focus:border-primary focus:ring-1 focus:ring-primary"
                                placeholder="Máx">
                        </div>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold">Área (m²)</label>
                        <div class="flex items-center space-x-2">
                            <input type="number" wire:model.live.debounce.500ms="areaMin" min="0"
                                class="px-2 py-1 w-1/2 bg-gray-50 rounded-lg border-gray-200 focus:border-primary focus:ring-1 focus:ring-primary"
                                placeholder="Mín">
                            <span>-</span>
                            <input type="number" wire:model.live.debounce.500ms="areaMax" min="0"
                                class="px-2 py-1 w-1/2 bg-gray-50 rounded-lg border-gray-200 focus:border-primary focus:ring-1 focus:ring-primary"
                                placeholder="Máx">
                        </div>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold">Quartos</label>
                        <select wire:model.live="bedrooms"
                            class="px-4 py-2 w-full bg-gray-50 rounded-lg border-gray-200 focus:border-primary focus:ring-1 focus:ring-primary">
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
                            class="px-4 py-2 w-full bg-gray-50 rounded-lg border-gray-200 focus:border-primary focus:ring-1 focus:ring-primary">
                            <option value="">Qualquer</option>
                            <option value="1">1+</option>
                            <option value="2">2+</option>
                            <option value="3">3+</option>
                            <option value="4">4+</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold">Vagas de Garagem</label>
                        <select wire:model.live="garageSpaces"
                            class="px-4 py-2 w-full bg-gray-50 rounded-lg border-gray-200 focus:border-primary focus:ring-1 focus:ring-primary">
                            <option value="">Qualquer</option>
                            <option value="1">1+</option>
                            <option value="2">2+</option>
                            <option value="3">3+</option>
                            <option value="4">4+</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold">Bairro</label>
                        <input type="text" wire:model.live.debounce.500ms="neighborhood"
                            class="px-4 py-2 w-full bg-gray-50 rounded-lg border-gray-200 focus:border-primary focus:ring-1 focus:ring-primary"
                            placeholder="Digite o bairro">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold">CEP</label>
                        <input type="text" wire:model.live.debounce.500ms="cep"
                            class="px-4 py-2 w-full bg-gray-50 rounded-lg border-gray-200 focus:border-primary focus:ring-1 focus:ring-primary"
                            placeholder="Ex: 25900-000 ou 25900000"
                            maxlength="9">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold">Área Útil (m²)</label>
                        <div class="flex items-center space-x-2">
                            <input type="number" wire:model.live.debounce.500ms="areaUtilMin" min="0"
                                class="px-2 py-1 w-1/2 bg-gray-50 rounded-lg border-gray-200 focus:border-primary focus:ring-1 focus:ring-primary"
                                placeholder="Mín">
                            <span>-</span>
                            <input type="number" wire:model.live.debounce.500ms="areaUtilMax" min="0"
                                class="px-2 py-1 w-1/2 bg-gray-50 rounded-lg border-gray-200 focus:border-primary focus:ring-1 focus:ring-primary"
                                placeholder="Máx">
                        </div>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold">Terreno (m²)</label>
                        <div class="flex items-center space-x-2">
                            <input type="number" wire:model.live.debounce.500ms="terrenoMin" min="0"
                                class="px-2 py-1 w-1/2 bg-gray-50 rounded-lg border-gray-200 focus:border-primary focus:ring-1 focus:ring-primary"
                                placeholder="Mín">
                            <span>-</span>
                            <input type="number" wire:model.live.debounce.500ms="terrenoMax" min="0"
                                class="px-2 py-1 w-1/2 bg-gray-50 rounded-lg border-gray-200 focus:border-primary focus:ring-1 focus:ring-primary"
                                placeholder="Máx">
                        </div>
                    </div>
                </form>
            </aside>

            <!-- Main Content -->
            <main class="flex-1">
                <!-- Error Message -->
                @if ($error)
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center">
                            <x-lucide-alert-circle class="w-5 h-5 text-red-500 mr-2" />
                            <span class="text-red-700">{{ $error }}</span>
                            <button wire:click="retryLoad"
                                class="ml-auto text-red-600 hover:text-red-800 text-sm underline">
                                Tentar novamente
                            </button>
                        </div>
                    </div>
                @endif

                <!-- Loading State -->
                <div wire:loading wire:target="filter,loadProperties,setSortBy" class="mb-6">
                    <div class="flex items-center p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-blue-600 mr-2"></div>
                        <span class="text-blue-700">Carregando imóveis...</span>
                    </div>
                </div>

                <div class="flex flex-col gap-4 mb-6 md:flex-row md:items-center md:justify-between">
                    <div class="text-sm text-gray-700">
                        {{ $propertiesFound }} imóveis encontrados
                    </div>
                    <div class="flex gap-2 items-center">
                        <span class="text-sm text-gray-500">Exibir:</span>
                        <button wire:click="setViewMode('grid')"
                            class="p-2 rounded hover:bg-gray-200 transition-colors {{ $viewMode === 'grid' ? 'bg-gray-200' : '' }}"
                            title="Grade">
                            <x-lucide-grid class="w-5 h-5" />
                        </button>
                        <button wire:click="setViewMode('list')"
                            class="p-2 rounded hover:bg-gray-200 transition-colors {{ $viewMode === 'list' ? 'bg-gray-200' : '' }}"
                            title="Lista">
                            <x-lucide-list class="w-5 h-5" />
                        </button>
                        <span class="ml-4 text-sm text-gray-500">Ordenar por:</span>
                        <select wire:model.live="sortBy"
                            class="px-2 py-1 text-sm bg-gray-50 rounded border-gray-200 focus:border-primary focus:ring-1 focus:ring-primary">
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
                            @livewire('imovel-card', ['imovel' => $imovel], key($imovel->id))
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
                        <h3 class="text-lg font-semibold text-gray-600 mb-2">
                            @if ($error)
                                Erro ao carregar imóveis
                            @else
                                Nenhum imóvel encontrado
                            @endif
                        </h3>
                        <p class="text-gray-500">
                            @if ($error)
                                Tente novamente ou ajuste os filtros de busca.
                            @else
                                Tente ajustar os filtros de busca para encontrar mais resultados.
                            @endif
                        </p>
                        @if ($error)
                            <button wire:click="retryLoad"
                                class="mt-4 px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark">
                                Tentar novamente
                            </button>
                        @endif
                    </div>
                @endif
            </main>
        </div>
    </div>
</main>
