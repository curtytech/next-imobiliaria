<section id="simulator" class="py-16 bg-white md:py-24">
    <div class="container px-4 mx-auto">
        <div class="mb-12 text-center">
            <h2 class="text-3xl font-bold text-gray-800 md:text-4xl">Simulador de Financiamento</h2>
            <p class="mt-2 text-lg text-gray-600">Simule o financiamento do seu imóvel e saiba o valor dos juros e amortização</p>
        </div>
        <div class="p-8 mx-auto max-w-7xl" 
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
            <div class="flex flex-col gap-8 lg:flex-row lg:items-start lg:gap-12">
                <!-- Sliders -->
                <div class="order-2 lg:order-1 flex-1 lg:pr-8 grid grid-cols-1 md:grid-cols-2 gap-6">
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
                <div class="order-1 lg:order-2 lg:max-w-lg lg:flex-shrink-0 flex justify-center">
                    <div class="p-6 bg-white rounded-xl shadow-lg">
                        <div class="relative w-[28rem] h-[28rem] mx-auto">
                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 80 80">
                                <!-- Círculo de fundo -->
                                <circle cx="40" cy="40" r="35" fill="none" stroke="#e5e7eb" stroke-width="6"></circle>
                                
                                <!-- Amortização (60%) -->
                                <circle cx="40" cy="40" r="35" fill="none" stroke="#3b82f6" stroke-width="6" 
                                        stroke-dasharray="131.95 219.91" 
                                        stroke-dashoffset="0" 
                                        stroke-linecap="round"></circle>
                                
                                <!-- Juros (35%) -->
                                <circle cx="40" cy="40" r="35" fill="none" stroke="#ef4444" stroke-width="6" 
                                        stroke-dasharray="76.97 219.91" 
                                        stroke-dashoffset="-131.95" 
                                        stroke-linecap="round"></circle>
                                
                                <!-- Seguro (5%) -->
                                <circle cx="40" cy="40" r="35" fill="none" stroke="#f59e0b" stroke-width="6" 
                                        stroke-dasharray="10.99 219.91" 
                                        stroke-dashoffset="-208.92" 
                                        stroke-linecap="round"></circle>
                            </svg>
                            
                            <!-- Valores no centro -->
                            <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-4">
                                <span class="text-2xl font-bold text-gray-800">Valor da 1ª parcela</span>
                                <span class="text-3xl font-bold text-gray-900 mb-3" x-text="formatCurrency(monthlyPayment) + ' /mês'"></span>
                                <span class="text text-gray-600">Renda mínima (<span class="font-medium" x-text="formatCurrency(minimumIncome)"></span>)</span>
                                <span class="text text-blue-600">Amortização [<span x-text="formatCurrency(monthlyAmortization) + ' por mês'"></span>]</span>
                                <span class="text text-red-500">Juros [<span x-text="formatCurrency(monthlyInterest) + ' por mês'"></span>]</span>
                                <span class="text text-orange-500">Seguros & Taxas (<span x-text="formatCurrency(monthlyInsurance)"></span>)</span>
                            </div>
                        </div>
                        
                        <!-- Contador de imóveis -->
                        <div class="mt-4 text-center text-sm text-gray-600" x-text="'Encontramos ' + availableProperties + ' imóveis no seu perfil.'"></div>
                        <a :href="'/search?priceMax=' + propertyValue" class="block py-3 mt-4 w-full font-semibold text-white text-center rounded-lg shadow-md transition bg-red-600 hover:bg-red-700">VER OS IMÓVEIS</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
