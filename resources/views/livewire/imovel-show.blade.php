<?php

use function Livewire\Volt\{state, mount, computed};
use App\Models\Imovel;
use Illuminate\Support\Facades\Log;

state([
    'imovel' => null,
    'loading' => false,
    'error' => null,
    'currentImageIndex' => 0,
    'showContactModal' => false,
    'contactForm' => [
        'name' => '',
        'email' => '',
        'phone' => '',
        'message' => '',
    ],
]);

mount(function ($id) {
    try {
        $this->loading = true;
        $this->error = null;
        
        $this->imovel = Imovel::with(['tipoImovel', 'statusImovel', 'corretor'])->findOrFail($id);
        
        // Set default message for contact form
        $this->contactForm['message'] = "Olá! Tenho interesse no imóvel: {$this->imovel->titulo}";
        
        $this->loading = false;
    } catch (\Exception $e) {
        Log::error('Error loading property details: ' . $e->getMessage());
        $this->error = 'Imóvel não encontrado ou erro ao carregar os detalhes.';
        $this->loading = false;
    }
});

$nextImage = function () {
    if ($this->imovel && $this->imovel->fotos && count($this->imovel->fotos) > 1) {
        $this->currentImageIndex = ($this->currentImageIndex + 1) % count($this->imovel->fotos);
    }
};

$previousImage = function () {
    if ($this->imovel && $this->imovel->fotos && count($this->imovel->fotos) > 1) {
        $this->currentImageIndex = ($this->currentImageIndex - 1 + count($this->imovel->fotos)) % count($this->imovel->fotos);
    }
};

$setImageIndex = function ($index) {
    if ($this->imovel && $this->imovel->fotos && $index >= 0 && $index < count($this->imovel->fotos)) {
        $this->currentImageIndex = $index;
    }
};

$toggleContactModal = function () {
    $this->showContactModal = !$this->showContactModal;
};

$submitContactForm = function () {
    try {
        // Validate form
        $this->validate([
            'contactForm.name' => 'required|min:2',
            'contactForm.email' => 'required|email',
            'contactForm.phone' => 'required|min:10',
            'contactForm.message' => 'required|min:10',
        ]);

        // Here you would typically send an email or save to database
        // For now, we'll just show a success message
        session()->flash('contact_success', 'Mensagem enviada com sucesso! Entraremos em contato em breve.');
        
        // Reset form
        $this->contactForm = [
            'name' => '',
            'email' => '',
            'phone' => '',
            'message' => "Olá! Tenho interesse no imóvel: {$this->imovel->titulo}",
        ];
        
        $this->showContactModal = false;
        
    } catch (\Exception $e) {
        Log::error('Error submitting contact form: ' . $e->getMessage());
        session()->flash('contact_error', 'Erro ao enviar mensagem. Tente novamente.');
    }
};

$currentImage = computed(function () {
    if (!$this->imovel || !$this->imovel->fotos || empty($this->imovel->fotos)) {
        return 'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?q=80&w=800&auto=format&fit=crop';
    }
    
    return $this->imovel->fotos[$this->currentImageIndex] ?? $this->imovel->fotos[0];
});

$hasMultipleImages = computed(function () {
    return $this->imovel && $this->imovel->fotos && count($this->imovel->fotos) > 1;
});

$propertyTypeLabel = computed(function () {
    if (!$this->imovel) return '';
    
    return match ($this->imovel->tipo) {
        'casa' => 'Casa',
        'apartamento' => 'Apartamento',
        'terreno' => 'Terreno',
        'comercial' => 'Comercial',
        'loja' => 'Loja',
        'galpao' => 'Galpão',
        'sala' => 'Sala',
        default => ucfirst($this->imovel->tipo),
    };
});

?>

<main>
    <div class="min-h-screen bg-gray-50">
        <!-- Loading State -->
        @if ($loading)
            <div class="flex items-center justify-center min-h-screen">
                <div class="flex flex-col items-center">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary mb-4"></div>
                    <span class="text-gray-600">Carregando detalhes do imóvel...</span>
                </div>
            </div>
        @elseif ($error)
            <!-- Error State -->
            <div class="container mx-auto px-4 py-8">
                <div class="text-center py-12">
                    <x-lucide-alert-circle class="w-16 h-16 mx-auto text-red-400 mb-4" />
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">Erro ao carregar imóvel</h1>
                    <p class="text-gray-600 mb-6">{{ $error }}</p>
                    <a href="{{ route('welcome') }}" 
                       class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors">
                        <x-lucide-arrow-left class="w-4 h-4 mr-2" />
                        Voltar ao início
                    </a>
                </div>
            </div>
        @elseif ($imovel)
            <!-- Property Details -->
            <div class="container mx-auto px-4 py-8">
                <!-- Breadcrumb -->
                <nav class="mb-6">
                    <ol class="flex items-center space-x-2 text-sm text-gray-500">
                        <li>
                            <a href="{{ route('welcome') }}" class="hover:text-primary">Início</a>
                        </li>
                        <li>
                            <x-lucide-chevron-right class="w-4 h-4" />
                        </li>
                        <li>
                            <a href="{{ route('search') }}" class="hover:text-primary">Buscar</a>
                        </li>
                        <li>
                            <x-lucide-chevron-right class="w-4 h-4" />
                        </li>
                        <li class="text-gray-900">{{ $imovel->titulo }}</li>
                    </ol>
                </nav>

                <!-- Property Header -->
                <div class="mb-8">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                @if ($imovel->destaque)
                                    <span class="px-3 py-1 text-xs font-bold text-white rounded-full bg-primary">
                                        Destaque
                                    </span>
                                @endif
                                <span class="px-3 py-1 text-xs font-medium text-gray-600 bg-gray-100 rounded-full">
                                    {{ $this->propertyTypeLabel }}
                                </span>
                            </div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $imovel->titulo }}</h1>
                            <p class="text-gray-600">
                                <x-lucide-map-pin class="inline w-4 h-4 mr-1" />
                                {{ $imovel->endereco }}, {{ $imovel->bairro }} - {{ $imovel->cidade }}, {{ $imovel->estado }}
                            </p>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold text-primary mb-1">
                                {{ $imovel->preco_formatado ?? 'Preço sob consulta' }}
                            </div>
                            <div class="text-sm text-gray-500">Código: #{{ $imovel->id }}</div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                    <!-- Main Content -->
                    <div class="lg:col-span-2">
                        <!-- Image Gallery -->
                        <div class="mb-8">
                            <div class="relative bg-white rounded-xl shadow overflow-hidden">
                                @if ($this->hasMultipleImages)
                                    <!-- Navigation Buttons -->
                                    <button wire:click="previousImage" 
                                            class="absolute left-4 top-1/2 transform -translate-y-1/2 z-10 p-2 bg-white/80 rounded-full shadow hover:bg-white transition-colors">
                                        <x-lucide-chevron-left class="w-6 h-6" />
                                    </button>
                                    <button wire:click="nextImage" 
                                            class="absolute right-4 top-1/2 transform -translate-y-1/2 z-10 p-2 bg-white/80 rounded-full shadow hover:bg-white transition-colors">
                                        <x-lucide-chevron-right class="w-6 h-6" />
                                    </button>
                                    
                                    <!-- Image Counter -->
                                    <div class="absolute top-4 right-4 z-10 px-3 py-1 bg-black/50 text-white text-sm rounded-full">
                                        {{ $currentImageIndex + 1 }} / {{ count($imovel->fotos) }}
                                    </div>
                                @endif
                                
                                <img src="{{ $this->currentImage }}" 
                                     alt="{{ $imovel->titulo }}" 
                                     class="w-full h-96 object-cover">
                            </div>

                            <!-- Thumbnail Gallery -->
                            @if ($this->hasMultipleImages)
                                <div class="flex gap-2 mt-4 overflow-x-auto">
                                    @foreach ($imovel->fotos as $index => $foto)
                                        <button wire:click="setImageIndex({{ $index }})"
                                                class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden border-2 transition-colors {{ $index === $currentImageIndex ? 'border-primary' : 'border-gray-200' }}">
                                            <img src="{{ $foto }}" 
                                                 alt="{{ $imovel->titulo }}" 
                                                 class="w-full h-full object-cover">
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Property Description -->
                        <div class="bg-white rounded-xl shadow p-6 mb-8">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Descrição</h2>
                            <div class="prose prose-gray max-w-none">
                                <p class="text-gray-700 leading-relaxed">{{ $imovel->descricao }}</p>
                            </div>
                        </div>

                        <!-- Property Characteristics -->
                        @if ($imovel->caracteristicas && count($imovel->caracteristicas) > 0)
                            <div class="bg-white rounded-xl shadow p-6 mb-8">
                                <h2 class="text-xl font-bold text-gray-900 mb-4">Características</h2>
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    @foreach ($imovel->caracteristicas as $key => $value)
                                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                            <span class="font-medium text-gray-700">{{ $key }}</span>
                                            <span class="text-gray-600">{{ $value }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Videos Section -->
                        @if ($imovel->videos && count($imovel->videos) > 0)
                            <div class="bg-white rounded-xl shadow p-6">
                                <h2 class="text-xl font-bold text-gray-900 mb-4">Vídeos</h2>
                                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                                    @foreach ($imovel->videos as $videoUrl)
                                        @php
                                            $videoId = $imovel->extractYouTubeId($videoUrl);
                                        @endphp
                                        @if ($videoId)
                                            <div class="relative pb-[56.25%] h-0 rounded-lg overflow-hidden">
                                                <iframe src="https://www.youtube.com/embed/{{ $videoId }}" 
                                                        class="absolute top-0 left-0 w-full h-full"
                                                        frameborder="0" 
                                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                        allowfullscreen>
                                                </iframe>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6">
                        <!-- Contact Card -->
                        <div class="bg-white rounded-xl shadow p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Interessado?</h3>
                            <div class="space-y-4">
                                <button wire:click="toggleContactModal"
                                        class="w-full py-3 px-4 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors font-semibold">
                                    <x-lucide-phone class="inline w-4 h-4 mr-2" />
                                    Solicitar Informações
                                </button>
                                <button class="w-full py-3 px-4 border border-primary text-primary rounded-lg hover:bg-primary hover:text-white transition-colors font-semibold">
                                    <x-lucide-message-circle class="inline w-4 h-4 mr-2" />
                                    WhatsApp
                                </button>
                            </div>
                        </div>

                        <!-- Property Details Card -->
                        <div class="bg-white rounded-xl shadow p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Detalhes do Imóvel</h3>
                            <div class="space-y-4">
                                @if ($imovel->area)
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-600">Área Total</span>
                                        <span class="font-semibold">{{ $imovel->area }} m²</span>
                                    </div>
                                @endif
                                
                                @if ($imovel->area_util)
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-600">Área Útil</span>
                                        <span class="font-semibold">{{ $imovel->area_util }} m²</span>
                                    </div>
                                @endif
                                
                                @if ($imovel->terreno)
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-600">Terreno</span>
                                        <span class="font-semibold">{{ $imovel->terreno }} m²</span>
                                    </div>
                                @endif
                                
                                @if ($imovel->area_constr)
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-600">Área Construída</span>
                                        <span class="font-semibold">{{ $imovel->area_constr }} m²</span>
                                    </div>
                                @endif
                                
                                @if ($imovel->quartos)
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-600">Quartos</span>
                                        <span class="font-semibold">{{ $imovel->quartos }}</span>
                                    </div>
                                @endif
                                
                                @if ($imovel->banheiros)
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-600">Banheiros</span>
                                        <span class="font-semibold">{{ $imovel->banheiros }}</span>
                                    </div>
                                @endif
                                
                                @if ($imovel->vagas_garagem)
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-600">Vagas de Garagem</span>
                                        <span class="font-semibold">{{ $imovel->vagas_garagem }}</span>
                                    </div>
                                @endif
                                
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600">Status</span>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $imovel->statusImovel?->nome === 'Disponível' ? 'bg-green-100 text-green-800' : 
                                           ($imovel->statusImovel?->nome === 'Vendido' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ $imovel->statusImovel?->nome ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Location Card -->
                        <div class="bg-white rounded-xl shadow p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Localização</h3>
                            <div class="space-y-3 text-sm">
                                <div>
                                    <span class="text-gray-600">Endereço:</span>
                                    <p class="font-medium">{{ $imovel->endereco }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-600">Bairro:</span>
                                    <p class="font-medium">{{ $imovel->bairro }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-600">Cidade:</span>
                                    <p class="font-medium">{{ $imovel->cidade }} - {{ $imovel->estado }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-600">CEP:</span>
                                    <p class="font-medium">{{ $imovel->cep }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Modal -->
            @if ($showContactModal)
                <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                             wire:click="toggleContactModal"></div>

                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-primary bg-opacity-100 sm:mx-0 sm:h-10 sm:w-10">
                                        <x-lucide-phone class="h-6 w-6 text-white" />
                                    </div>
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                            Solicitar Informações
                                        </h3>
                                        <div class="mt-2">
                                            <form wire:submit.prevent="submitContactForm" class="space-y-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Nome</label>
                                                    <input type="text" wire:model="contactForm.name" 
                                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                                                    @error('contactForm.name') 
                                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">E-mail</label>
                                                    <input type="email" wire:model="contactForm.email" 
                                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                                                    @error('contactForm.email') 
                                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Telefone</label>
                                                    <input type="tel" wire:model="contactForm.phone" 
                                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                                                    @error('contactForm.phone') 
                                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Mensagem</label>
                                                    <textarea wire:model="contactForm.message" rows="4"
                                                              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary"></textarea>
                                                    @error('contactForm.message') 
                                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="button" wire:click="submitContactForm"
                                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-medium text-white hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:ml-3 sm:w-auto sm:text-sm">
                                    Enviar Mensagem
                                </button>
                                <button type="button" wire:click="toggleContactModal"
                                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Success/Error Messages -->
            @if (session()->has('contact_success'))
                <div class="fixed bottom-4 right-4 z-50">
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 shadow-lg">
                        <div class="flex items-center">
                            <x-lucide-check-circle class="w-5 h-5 text-green-500 mr-2" />
                            <span class="text-green-700">{{ session('contact_success') }}</span>
                        </div>
                    </div>
                </div>
            @endif

            @if (session()->has('contact_error'))
                <div class="fixed bottom-4 right-4 z-50">
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 shadow-lg">
                        <div class="flex items-center">
                            <x-lucide-alert-circle class="w-5 h-5 text-red-500 mr-2" />
                            <span class="text-red-700">{{ session('contact_error') }}</span>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
</main>