@extends('layouts.site')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="container mx-auto px-4 py-8 flex flex-col items-center">
        <div class="w-full max-w-5xl bg-white rounded-2xl shadow-lg overflow-hidden">
            <!-- Galeria principal -->
            <div class="relative bg-black">
                <div class="swiper-container" id="mainGallery">
                    <div class="swiper-wrapper">
                        <!-- Exemplo de imagens, substitua por loop dinâmico -->
                        <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1580587771525-78b9dba3b914?q=80&w=800" class="object-cover w-full h-96" alt="Foto principal"></div>
                        <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=800" class="object-cover w-full h-96" alt="Foto 2"></div>
                    </div>
                    <!-- Setas -->
                    <button class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/70 rounded-full p-2 z-10" id="prevSlide"><i data-lucide="chevron-left" class="w-6 h-6"></i></button>
                    <button class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/70 rounded-full p-2 z-10" id="nextSlide"><i data-lucide="chevron-right" class="w-6 h-6"></i></button>
                    <!-- Fechar -->
                    <a href="{{ url()->previous() }}" class="absolute top-4 right-4 bg-white/80 rounded-full p-2 z-20 hover:bg-red-100 transition"><i data-lucide="x" class="w-6 h-6"></i></a>
                </div>
            </div>

            <!-- Tabs -->
            <div class="flex justify-center gap-2 bg-gray-100 py-3 border-b">
                <button class="tab-btn active" data-tab="fotos">Fotos</button>
                <button class="tab-btn" data-tab="video">Vídeo</button>
                <button class="tab-btn" data-tab="mapa">Mapa</button>
                <button class="tab-btn" data-tab="rua">Vista da rua</button>
            </div>

            <!-- Conteúdo das tabs -->
            <div class="p-6 bg-white">
                <!-- Tab: Fotos -->
                <div class="tab-content" id="tab-fotos">
                    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4">
                        <div>
                            <h1 class="text-2xl font-bold text-primary mb-1">Sobrado Centro - Magé</h1>
                            <div class="text-gray-600 text-sm mb-1">Rua Major Magalhães - Centro - Magé - RJ</div>
                            <div class="text-xs text-gray-400">Cód.502</div>
                        </div>
                        <div class="flex flex-wrap gap-4 mt-4 md:mt-0">
                            <div class="flex items-center gap-1 text-gray-700"><i data-lucide="ruler" class="w-4 h-4"></i> <span>120 m² útil</span></div>
                            <div class="flex items-center gap-1 text-gray-700"><i data-lucide="ruler-square" class="w-4 h-4"></i> <span>120 m² constr.</span></div>
                            <div class="flex items-center gap-1 text-gray-700"><i data-lucide="bed-double" class="w-4 h-4"></i> <span>3 Dorms</span></div>
                            <div class="flex items-center gap-1 text-gray-700"><i data-lucide="bath" class="w-4 h-4"></i> <span>2 Banheiros</span></div>
                            <div class="flex items-center gap-1 text-gray-700"><i data-lucide="key-round" class="w-4 h-4"></i> <span>1 Suíte</span></div>
                        </div>
                    </div>
                    <div class="mb-6 text-gray-800 leading-relaxed">
                        <p>Este sobrado localizado no Centro de Magé é a opção perfeita para quem busca conforto e praticidade em um só lugar. Com 3 dormitórios, é ideal para famílias que desejam um espaço amplo e aconchegante para viver. Além disso, o imóvel conta com 2 banheiros, garantindo a comodidade de todos os moradores.</p>
                        <p class="mt-2">O sobrado possui uma estrutura moderna e bem distribuída, com ambientes iluminados e arejados. A cozinha é espaçosa, oferecendo praticidade no dia a dia. A sala de estar é aconchegante e perfeita para reunir a família e receber amigos.</p>
                        <p class="mt-2">Este sobrado é uma excelente oportunidade para quem busca um imóvel de qualidade e com um preço justo. Não perca a chance de morar em um lugar que oferece conforto, praticidade e segurança.</p>
                        <p class="mt-2 font-semibold">Agende já uma visita!</p>
                    </div>
                    <div class="mb-4 bg-gray-50 p-4 rounded-lg border">
                        <div class="font-bold text-gray-700 mb-1">Para mais informações entre em contato:</div>
                        <div class="flex flex-col md:flex-row md:gap-8 text-gray-700 text-sm">
                            <span>Tel: <a href="tel:2126332403" class="text-primary hover:underline">21 2633-2403</a></span>
                            <span>Cel/WhatsApp: <a href="https://wa.me/21983357879" class="text-primary hover:underline">21 98335-7879</a></span>
                        </div>
                    </div>
                    <!-- Mini galeria -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-6">
                        <img src="https://images.unsplash.com/photo-1580587771525-78b9dba3b914?q=80&w=400" class="rounded-lg object-cover h-32 w-full" alt="Foto 1">
                        <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=400" class="rounded-lg object-cover h-32 w-full" alt="Foto 2">
                        <img src="https://images.unsplash.com/photo-1460518451285-97b6aa326961?q=80&w=400" class="rounded-lg object-cover h-32 w-full" alt="Foto 3">
                        <img src="https://images.unsplash.com/photo-1472224371017-08207f84aaae?q=80&w=400" class="rounded-lg object-cover h-32 w-full" alt="Foto 4">
                    </div>
                </div>
                <!-- Tab: Vídeo -->
                <div class="tab-content hidden" id="tab-video">
                    <div class="flex justify-center">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="YouTube video" frameborder="0" allowfullscreen class="rounded-lg w-full max-w-2xl aspect-video"></iframe>
                    </div>
                </div>
                <!-- Tab: Mapa -->
                <div class="tab-content hidden" id="tab-mapa">
                    <div class="flex justify-center">
                        <iframe src="https://www.google.com/maps?q=Centro+Magé+RJ&output=embed" class="rounded-lg w-full max-w-2xl aspect-video" allowfullscreen></iframe>
                    </div>
                </div>
                <!-- Tab: Vista da rua -->
                <div class="tab-content hidden" id="tab-rua">
                    <div class="flex justify-center">
                        <iframe src="https://www.google.com/maps?q=Centro+Magé+RJ&layer=c&cbll=-22.6556,-43.0319&cbp=11,0,0,0,0&output=svembed" class="rounded-lg w-full max-w-2xl aspect-video" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
        <!-- Botão voltar -->
        <div class="w-full max-w-5xl flex justify-start mt-4">
            <a href="{{ url()->previous() }}" class="flex items-center gap-2 text-primary font-semibold hover:underline"><i data-lucide="arrow-left" class="w-5 h-5"></i> VOLTAR</a>
        </div>
    </div>
</div>

<!-- Scripts para tabs e galeria (exemplo simples, substitua por JS real se necessário) -->
<script>
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('hidden'));
            document.getElementById('tab-' + this.dataset.tab).classList.remove('hidden');
        });
    });
    // Galeria: substitua por Swiper ou outro plugin se desejar
    let slides = document.querySelectorAll('#mainGallery .swiper-slide');
    let current = 0;
    function showSlide(idx) {
        slides.forEach((s, i) => s.style.display = i === idx ? 'block' : 'none');
    }
    showSlide(current);
    document.getElementById('prevSlide').onclick = () => { current = (current - 1 + slides.length) % slides.length; showSlide(current); };
    document.getElementById('nextSlide').onclick = () => { current = (current + 1) % slides.length; showSlide(current); };
</script>

<style>
    .tab-btn { @apply px-4 py-2 rounded-t-lg font-semibold text-gray-600 bg-gray-200 transition; }
    .tab-btn.active { @apply bg-primary text-white; }
</style>
@endsection 