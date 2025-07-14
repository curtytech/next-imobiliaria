<section id="simulator" class="py-16 bg-white md:py-24">
    <div class="container px-4 mx-auto">
        <div class="mb-12 text-center">
            <h2 class="text-3xl font-bold text-gray-800 md:text-4xl">Simulador de Financiamento</h2>
            <p class="mt-2 text-lg text-gray-600">Planeje a compra do seu imóvel com uma simulação rápida.</p>
        </div>
        <div class="p-8 mx-auto max-w-4xl bg-gray-50 rounded-2xl shadow-inner" x-data="loanSimulator()">
            <div class="grid grid-cols-1 gap-8 items-center md:grid-cols-2">
                <!-- Sliders -->
                <div>
                    <div class="mb-6">
                        <label for="propertyValue" class="block mb-2 font-semibold text-gray-700">Valor do
                            Imóvel</label>
                        <input type="range" id="propertyValue" min="50000" max="2000000" step="10000"
                            x-model.number="propertyValue">
                        <p class="mt-2 text-2xl font-bold text-center text-primary"
                            x-text="formatCurrency(propertyValue)"></p>
                    </div>
                    <div class="mb-6">
                        <label for="downPayment" class="block mb-2 font-semibold text-gray-700">Valor da Entrada</label>
                        <input type="range" id="downPayment" min="10000" max="1000000" step="5000"
                            x-model.number="downPayment">
                        <p class="mt-2 text-2xl font-bold text-center text-primary"
                            x-text="formatCurrency(downPayment)"></p>
                    </div>
                    <div>
                        <label for="loanTerm" class="block mb-2 font-semibold text-gray-700">Prazo (em anos)</label>
                        <input type="range" id="loanTerm" min="5" max="35" step="1"
                            x-model.number="loanTerm">
                        <p class="mt-2 text-2xl font-bold text-center text-primary" x-text="loanTerm + ' anos'"></p>
                    </div>
                </div>
                <!-- Results -->
                <div class="p-8 text-center bg-white rounded-xl border-2 shadow-lg border-primary">
                    <p class="mb-2 text-gray-600">Valor da Parcela Mensal</p>
                    <p class="mb-4 text-4xl font-extrabold text-gray-800 md:text-5xl"
                        x-text="formatCurrency(monthlyPayment)"></p>
                    <p class="text-sm text-gray-500">Taxa de juros estimada: <span
                            x-text="(interestRate * 100).toFixed(1)"></span>% a.a.</p>
                    <button
                        class="py-3 mt-6 w-full font-semibold text-white rounded-lg shadow-md transition bg-primary hover:bg-primary-dark">Buscar
                        imóveis nesta faixa</button>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function loanSimulator() {
        return {
            propertyValue: 300000,
            downPayment: 50000,
            loanTerm: 20,
            interestRate: 0.09,
            get monthlyPayment() {
                const principal = this.propertyValue - this.downPayment;
                const months = this.loanTerm * 12;
                const monthlyRate = this.interestRate / 12;
                return principal * monthlyRate / (1 - Math.pow(1 + monthlyRate, -months));
            },
            formatCurrency(value) {
                return value.toLocaleString('pt-BR', {
                    style: 'currency',
                    currency: 'BRL'
                });
            }
        }
    }
</script>
