<div class="glassmorphism p-4 md:p-6 rounded-2xl max-w-4xl mx-auto">
    <div class="flex justify-center mb-4 border-b border-white/20">
        <button wire:click="setType('venda')"
            class="px-6 py-2 rounded-t-lg text-lg font-semibold transition focus:outline-none {{ $propertyType === 'venda' ? 'bg-primary text-white' : 'text-white/80' }}">
            Comprar
        </button>
        <button wire:click="setType('aluguel')"
            class="px-6 py-2 rounded-t-lg text-lg font-semibold transition focus:outline-none {{ $propertyType === 'aluguel' ? 'bg-primary text-white' : 'text-white/80' }}">
            Alugar
        </button>
    </div>
    <form wire:submit.prevent="search" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 items-center">
        <div class="md:col-span-1 lg:col-span-1">
            <label for="search-type" class="sr-only">Tipo</label>
            <select id="search-type" wire:model="propertyKind"
                class="w-full pl-4 pr-8 py-3 rounded-lg text-gray-800 bg-white focus:outline-none focus:ring-2 focus:ring-primary">
                <option value="">Tipo</option>
                @foreach($tipoImovel as $tipo)
                    <option value="{{ $tipo->id }}">{{ $tipo->nome }}</option>
                @endforeach
            </select>
        </div>
        <div class="md:col-span-2 lg:col-span-2">
            <label for="search-location" class="sr-only">Localização</label>
            <div class="relative">
                <x-lucide-map-pin class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-500" />
                <input type="text" id="search-location" wire:model="location"
                    placeholder="Digite o bairro, condomínio ou cidade..."
                    class="w-full pl-12 pr-4 py-3 rounded-lg text-gray-800 bg-white focus:outline-none focus:ring-2 focus:ring-primary">
            </div>
        </div>
        <button type="submit"
            class="w-full bg-primary text-white font-bold py-3 rounded-lg hover:bg-primary-dark transition shadow-lg flex items-center justify-center space-x-2">
            <x-lucide-search class="w-5 h-5" />
            <span>Buscar</span>
        </button>
    </form>
</div>
<script>
    document.addEventListener('livewire:load', function() {
        if (window.lucide) {
            window.lucide.createIcons();
        }
    });
</script>
