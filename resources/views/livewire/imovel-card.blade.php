<div class="flex overflow-hidden flex-col bg-white rounded-xl shadow transition hover:shadow-lg">
    <a href="{{ route('imovel.show', $imovel->id) }}" class="block h-full">
    <div class="relative">
        <img src="{{ $imovel->imagem_principal }}" alt="{{ $imovel->titulo }}" class="object-cover w-full h-44">
        @if ($imovel->destaque)
            <span
                class="absolute top-3 left-3 px-3 py-1 text-xs font-bold text-white rounded-full bg-primary">Destaque</span>
        @endif
        <span class="absolute top-3 right-3 p-1 bg-white rounded-full border text-primary border-primary"><i
                data-lucide="heart" class="w-5 h-5"></i></span>
    </div>
    <div class="flex flex-col flex-1 p-4">
        <div class="flex gap-2 items-center mb-2">
            <span class="text-xs text-gray-500">{{ $imovel->tipo_imovel->nome ?? 'Tipo não informado' }}</span>
            <span class="text-xs text-gray-400">•</span>
            <span class="text-xs text-gray-500">{{ $imovel->localizacao }}</span>
        </div>
        <h3 class="mb-1 text-lg font-bold">{{ $imovel->titulo }}</h3>
        <div class="mb-2 text-xl font-bold text-primary">R$ {{ number_format($imovel->preco, 2, ',', '.') }}</div>
        <div class="flex gap-4 items-center mb-4 text-sm text-gray-600">
            <span class="flex gap-1 items-center"><x-lucide-bed-double class="w-4 h-4" /> {{ $imovel->quartos }}
                Quartos</span>
            <span class="flex gap-1 items-center"><x-lucide-bath class="w-4 h-4" /> {{ $imovel->banheiros }}
                Banheiro</span>
            <span class="flex gap-1 items-center"><x-lucide-ruler class="w-4 h-4" /> {{ $imovel->area }}m²</span>
        </div>
        <div class="flex gap-2 mt-auto">
            <x-button>
                Ver detalhes
            </x-button>
            <x-button>
                Contato
            </x-button>
        </div>
    </div>
    <div class="flex items-center p-4 border-t border-gray-100">
        <img src="https://placehold.co/32x32/EFEFEF/777777?text=BR" alt="Corretor" class="mr-2 w-8 h-8 rounded-full">
        <span class="text-xs text-gray-700">{{ $imovel->corretor->nome ?? 'Corretor Não Informado' }}</span>
    </div>
</a>
</div>
