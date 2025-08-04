<nav class="bg-white shadow">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <!-- <a href="/" class="text-xl font-bold text-primary">{{ config('app.name', 'Imobiliária Magé') }}</a> -->
        <a href="/" class="text-xl font-bold text-primary"><img src="{{ asset('img/logo_mcboutique.png') }}" alt="Mc Boutique" class="h-25 w-auto"></a>

        <ul class="flex gap-6">
            <li><a href="/search" class="text-primary text-lg font-base hover:text-secondary hover:font-bold">Buscar Imóveis</a></li>
            <li><a href="#featured" class="text-primary text-lg font-base hover:text-secondary hover:font-bold">Imóveis em Destaque</a></li>
            <li><a href="#simulator" class="text-primary text-lg font-base hover:text-secondary hover:font-bold">Simulador de Financiamento</a></li>
            <li><a href="#agents" class="text-primary text-lg font-base hover:text-secondary hover:font-bold">Corretores</a></li>
        </ul>
    </div>
</nav>