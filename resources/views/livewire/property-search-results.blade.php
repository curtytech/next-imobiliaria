<div class="min-h-screen bg-gray-50">
    <div class="container flex flex-col gap-8 px-4 py-8 mx-auto lg:flex-row">
        <!-- Sidebar Filters -->
        <aside class="p-6 mb-8 w-full bg-white rounded-xl shadow lg:w-64 lg:mb-0">
            <h2 class="mb-4 text-lg font-bold">Filtrar</h2>
            <form class="space-y-6">
                <div>
                    <label class="block mb-2 text-sm font-semibold">Cidade ou bairro</label>
                    <input type="text" class="px-4 py-2 w-full bg-gray-50 rounded-lg border-gray-200"
                        placeholder="Ex: Magé, Centro">
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
                        <input type="number" class="px-2 py-1 w-1/2 bg-gray-50 rounded-lg border-gray-200"
                            placeholder="Mín">
                        <span>-</span>
                        <input type="number" class="px-2 py-1 w-1/2 bg-gray-50 rounded-lg border-gray-200"
                            placeholder="Máx">
                    </div>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-semibold">Área útil (m²)</label>
                    <div class="flex items-center space-x-2">
                        <input type="number" class="px-2 py-1 w-1/2 bg-gray-50 rounded-lg border-gray-200"
                            placeholder="Mín">
                        <span>-</span>
                        <input type="number" class="px-2 py-1 w-1/2 bg-gray-50 rounded-lg border-gray-200"
                            placeholder="Máx">
                    </div>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-semibold">Quartos</label>
                    <select class="px-4 py-2 w-full bg-gray-50 rounded-lg border-gray-200">
                        <option>Qualquer</option>
                        <option>Nenhum (0)</option>
                        <option>1 quarto</option>
                        <option>2 quartos</option>
                        <option>3 quartos</option>
                        <option>4 quartos</option>
                        <option>5+ quartos</option>
                    </select>
                </div>
                <button type="submit"
                    class="py-2 mt-4 w-full font-semibold text-white rounded-lg bg-primary">Filtrar</button>
            </form>
        </aside>

        <!-- Main Content -->
        <main class="flex-1">
            <div class="flex flex-col gap-4 mb-6 md:flex-row md:items-center md:justify-between">
                <div class="text-sm text-gray-700">17 imóveis encontrados</div>
                <div class="flex gap-2 items-center">
                    <span class="text-sm text-gray-500">Exibir:</span>
                    <button class="p-2 rounded hover:bg-gray-200" title="Grade"><x-lucide-grid
                            class="w-5 h-5" /></button>
                    <button class="p-2 rounded hover:bg-gray-200" title="Lista"><x-lucide-list
                            class="w-5 h-5" /></button>
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
                    @livewire('imovel-card')
                @endfor
            </div>
            <!-- Pagination -->
            <div class="flex justify-center mt-8">
                <nav class="inline-flex -space-x-px">
                    <a href="#"
                        class="px-3 py-2 text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100">&laquo;</a>
                    <a href="#" class="px-3 py-2 font-bold bg-white border border-gray-300 text-primary">1</a>
                    <a href="#"
                        class="px-3 py-2 text-gray-700 bg-white border border-gray-300 hover:bg-gray-100">2</a>
                    <a href="#"
                        class="px-3 py-2 text-gray-700 bg-white border border-gray-300 hover:bg-gray-100">3</a>
                    <a href="#"
                        class="px-3 py-2 text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100">&raquo;</a>
                </nav>
            </div>
        </main>
    </div>
</div>
