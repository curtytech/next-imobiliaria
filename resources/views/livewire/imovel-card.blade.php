<div class="@container flex overflow-hidden flex-col bg-white rounded-xl shadow transition hover:shadow-lg">
    <a href="{{ route('imovel.show', $imovel->id) }}" class="block h-full">
        <div class="relative">
            <img src="{{ $imovel->imagem_principal }}" alt="{{ $imovel->titulo }}" class="object-cover w-full h-44">
            @if ($imovel->destaque)
                <span class="absolute top-3 left-3 px-3 py-1 text-xs font-bold text-white rounded-full bg-primary">
                    Destaque
                </span>
            @endif
            {{-- <span class="absolute top-3 right-3 p-1 bg-white rounded-full border text-primary border-primary">
                <i data-lucide="heart" class="w-5 h-5"></i>
            </span> --}}
        </div>
        <div class="flex flex-col flex-1 p-4">
            <div class="flex gap-2 items-center mb-2">
                <span class="text-xs text-gray-500">{{ $imovel->tipoImovel->nome ?? 'Tipo não informado' }}</span>
                <span class="text-xs text-gray-400">•</span>
                <span class="text-xs text-gray-500">{{ $imovel->localizacao }}</span>
            </div>
            <h3 class="mb-1 text-lg font-bold">{{ $imovel->titulo }}</h3>
            <div class="mb-2 text-xl font-bold text-primary">R$ {{ number_format($imovel->preco, 2, ',', '.') }}</div>
            
            <!-- Layout responsivo das informações -->
            <div class="flex justify-between mb-4 text-sm text-gray-600 @[280px]:gap-4 @[280px]:justify-between">
                <!-- Quartos -->
                <div class="flex flex-col items-center gap-1 @[280px]:gap-1">
                    <x-lucide-bed-double class="w-4 h-4" />
                    <div class="text-center @[280px]:text-left">
                        <span class="block @[280px]:inline">{{ $imovel->quartos ?? 1 }}</span>
                        <span class="hidden @[280px]:inline">
                            Quarto<?= $imovel->quartos > 1 ? 's' : '' ?>
                        </span>
                    </div>
                </div>
                
                <!-- Banheiros -->
                <div class="flex flex-col items-center gap-1 @[280px]:gap-1">
                    <x-lucide-bath class="w-4 h-4" />
                    <div class="text-center @[280px]:text-left">
                        <span class="block @[280px]:inline">{{ $imovel->banheiros }}</span>
                        <span class="hidden @[280px]:inline">
                            Banheiro<?= $imovel->banheiros > 1 ? 's' : '' ?>
                        </span>
                    </div>
                </div>
                
                <!-- Área -->
                <div class="flex flex-col items-center gap-1 @[280px]:gap-1">
                    <x-lucide-ruler class="w-4 h-4" />
                    <div class="text-center @[280px]:text-left">
                        <span class="block @[280px]:inline">{{ $imovel->area }}m²</span>
                    </div>
                </div>
            </div>
            
            <div class="flex gap-2 mt-auto">
                <x-button class="!flex-1 @[280px]:!flex-none flex items-center justify-center gap-2">
                    <x-lucide-eye class="w-4 h-4" />
                    <span class="hidden @[280px]:inline">Ver detalhes</span>
                </x-button>
                
                <x-button class="!flex-1 @[280px]:!flex-none flex items-center justify-center gap-2">
                    <x-lucide-message-circle class="w-4 h-4" />
                    <span class="hidden @[280px]:inline">Contato</span>
                </x-button>
            </div>
        </div>
        <div class="flex items-center p-4 border-t border-gray-100">
            <img src="https://placehold.co/32x32/EFEFEF/777777?text=BR" alt="Corretor" class="mr-2 w-8 h-8 rounded-full">
            <span class="text-xs text-gray-700">{{ $imovel->corretor->name ?? 'Corretor Não Informado' }}</span>
        </div>
    </a>
</div>