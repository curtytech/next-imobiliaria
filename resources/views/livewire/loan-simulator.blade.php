<section id="simulator" class="py-16 bg-white md:py-24">
    <div class="container px-4 mx-auto">
        <div class="mb-12 text-center">
            <h2 class="text-3xl font-bold text-gray-800 md:text-4xl">Simulador de Financiamento</h2>
            <p class="mt-2 text-lg text-gray-600">Simule o financiamento do seu imóvel e saiba o valor dos juros e amortização</p>
        </div>
        <div class="p-8 mx-auto max-w-6xl bg-gray-50 rounded-2xl shadow-inner" 
             x-data="{
                 propertyValue: 700000,
                 downPaymentPercent: 20,
                 loanTerm: 30,
                 interestRate: 8.0,
                 availableProperties: 0,
                 debounceTimer: null,
                 
                 init() {
                     this.updateAvailableProperties();
                     this.$watch('propertyValue', () => {
                         clearTimeout(this.debounceTimer);
                         this.debounceTimer = setTimeout(() => {
                             this.updateAvailableProperties();
                         }, 500);
                     });
                 },
                 
                 async updateAvailableProperties() {
                     try {
                         const response = await fetch('/loan-simulator/properties-count', {
                             method: 'POST',
                             headers: {
                                 'Content-Type': 'application/json',
                                 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                             },
                             body: JSON.stringify({ maxPrice: this.propertyValue })
                         });
                         const data = await response.json();
                         this.availableProperties = data.count;
                     } catch (error) {
                         console.error('Erro ao buscar propriedades:', error);
                         this.availableProperties = 0;
                     }
                 },
                 
                 get downPaymentValue() {
                     return this.propertyValue * (this.downPaymentPercent / 100);
                 },
                 
                 get loanAmount() {
                     return this.propertyValue - this.downPaymentValue;
                 },
                 
                 get monthlyPayment() {
                     const principal = this.loanAmount;
                     const months = this.loanTerm * 12;
                     const monthlyRate = (this.interestRate / 100) / 12;
                     const payment = principal * monthlyRate / (1 - Math.pow(1 + monthlyRate, -months));
                     return payment + 89;
                 },
                 
                 get monthlyAmortization() {
                     const principal = this.loanAmount;
                     const months = this.loanTerm * 12;
                     const monthlyRate = (this.interestRate / 100) / 12;
                     const payment = principal * monthlyRate / (1 - Math.pow(1 + monthlyRate, -months));
                     const interest = principal * monthlyRate;
                     return payment - interest;
                 },
                 
                 get monthlyInterest() {
                     const principal = this.loanAmount;
                     const monthlyRate = (this.interestRate / 100) / 12;
                     return principal * monthlyRate;
                 },
                 
                 get monthlyInsurance() {
                     return 89;
                 },
                 
                 get minimumIncome() {
                     return this.monthlyPayment * 3.33;
                 },
                 
                 formatCurrency(value) {
                     return value.toLocaleString('pt-BR', {
                         style: 'currency',
                         currency: 'BRL'
                     });
                 }
             }">
            <div class="grid grid-cols-1 gap-8 items-start lg:grid-cols-2">
                <!-- Sliders -->
                <div class="lg:col-span-1">
                    <div class="mb-6">
                        <label for="propertyValue" class="block mb-2 font-semibold text-gray-700">Preço do Imóvel</label>
                        <input type="range" id="propertyValue" min="50000" max="2000000" step="10000"
                            x-model.number="propertyValue" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider">
                        <p class="mt-2 text-xl font-bold text-center text-primary"
                            x-text="formatCurrency(propertyValue)"></p>
                    </div>
                    <div class="mb-6">
                        <label for="downPaymentPercent" class="block mb-2 font-semibold text-gray-700">Entrada</label>
                        <input type="range" id="downPaymentPercent" min="10" max="80" step="5"
                            x-model.number="downPaymentPercent" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider">
                        <p class="mt-2 text-xl font-bold text-center text-primary"
                            x-text="downPaymentPercent + '%'"></p>
                        <p class="text-sm text-center text-gray-600"
                            x-text="formatCurrency(downPaymentValue)"></p>
                    </div>
                    <div class="mb-6">
                        <label for="loanTerm" class="block mb-2 font-semibold text-gray-700">Tempo de Financiamento</label>
                        <input type="range" id="loanTerm" min="5" max="35" step="1"
                            x-model.number="loanTerm" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider">
                        <p class="mt-2 text-xl font-bold text-center text-primary" x-text="loanTerm + ' anos'"></p>
                    </div>
                    <div>
                        <label for="interestRate" class="block mb-2 font-semibold text-gray-700">Taxa de Juros</label>
                        <input type="range" id="interestRate" min="6" max="15" step="0.1"
                            x-model.number="interestRate" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider">
                        <p class="mt-2 text-xl font-bold text-center text-primary" x-text="interestRate.toFixed(1) + '% ao ano'"></p>
                    </div>
                </div>
                
                <!-- Chart -->
                <div class="lg:col-span-1">
                    <div class="p-6 bg-white rounded-xl shadow-lg">
                        <div class="relative w-96 h-96 mx-auto">
                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 80 80">
                                <!-- Círculo de fundo -->
                                <circle cx="40" cy="40" r="35" fill="none" stroke="#e5e7eb" stroke-width="10"></circle>
                                
                                <!-- Amortização (60%) -->
                                <circle cx="40" cy="40" r="35" fill="none" stroke="#3b82f6" stroke-width="10" 
                                        stroke-dasharray="131.95 219.91" 
                                        stroke-dashoffset="0" 
                                        stroke-linecap="round"></circle>
                                
                                <!-- Juros (35%) -->
                                <circle cx="40" cy="40" r="35" fill="none" stroke="#ef4444" stroke-width="10" 
                                        stroke-dasharray="76.97 219.91" 
                                        stroke-dashoffset="-131.95" 
                                        stroke-linecap="round"></circle>
                                
                                <!-- Seguro (5%) -->
                                <circle cx="40" cy="40" r="35" fill="none" stroke="#f59e0b" stroke-width="10" 
                                        stroke-dasharray="10.99 219.91" 
                                        stroke-dashoffset="-208.92" 
                                        stroke-linecap="round"></circle>
                            </svg>
                            
                            <!-- Valores no centro -->
                            <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-4">
                                <span class="text-sm font-bold text-gray-800">Valor da 1ª parcela</span>
                                <span class="text-xl font-bold text-gray-900" x-text="formatCurrency(monthlyPayment) + ' /mês'"></span>
                                <span class="text-xs text-gray-600">Renda mínima (<span class="font-medium" x-text="formatCurrency(minimumIncome)"></span>)</span>
                                <span class="text-xs text-blue-600">Amortização [<span x-text="formatCurrency(monthlyAmortization) + ' por mês'"></span>]</span>
                                <span class="text-xs text-red-500">Juros [<span x-text="formatCurrency(monthlyInterest) + ' por mês'"></span>]</span>
                                <span class="text-xs text-orange-500">Seguros & Taxas (<span x-text="formatCurrency(monthlyInsurance)"></span>)</span>
                                <span class="text-xs text-gray-600 mt-2">Encontramos <span x-text="availableProperties"></span> imóveis no seu perfil.</span>
                            </div>
                        </div>
                        
                        <!-- Legenda -->
                        <div class="mt-6 space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                                    <span class="text-sm text-gray-600">Amortização</span>
                                </div>
                                <span class="text-sm font-medium" x-text="formatCurrency(monthlyAmortization)"></span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-red-500 rounded-full mr-2"></div>
                                    <span class="text-sm text-gray-600">Juros</span>
                                </div>
                                <span class="text-sm font-medium" x-text="formatCurrency(monthlyInterest)"></span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></div>
                                    <span class="text-sm text-gray-600">Seguros & Taxas</span>
                                </div>
                                <span class="text-sm font-medium" x-text="formatCurrency(monthlyInsurance)"></span>
                            </div>
                        </div>
                        <a :href="'/search?priceMax=' + propertyValue" class="block py-3 mt-4 w-full font-semibold text-white text-center rounded-lg shadow-md transition bg-red-600 hover:bg-red-700">VER OS IMÓVEIS</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
