<section id="simulator" class="py-16 bg-white md:py-24">
    <div class="container px-4 mx-auto">
        <div class="mb-12 text-center">
            <h2 class="text-3xl font-bold text-gray-800 md:text-4xl">Simulador de Financiamento</h2>
            <p class="mt-2 text-lg text-gray-600">Simule o financiamento do seu imóvel e saiba o valor dos juros e amortização</p>
        </div>
        <div class="p-8 mx-auto max-w-6xl bg-gray-50 rounded-2xl shadow-inner" x-data="loanSimulator()">
            <div class="grid grid-cols-1 gap-8 items-start lg:grid-cols-3">
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
                    <div>
                        <label for="loanTerm" class="block mb-2 font-semibold text-gray-700">Tempo de Financiamento</label>
                        <input type="range" id="loanTerm" min="5" max="35" step="1"
                            x-model.number="loanTerm" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider">
                        <p class="mt-2 text-xl font-bold text-center text-primary" x-text="loanTerm + ' anos'"></p>
                    </div>
                </div>
                
                <!-- Results -->
                <div class="lg:col-span-1">
                    <div class="p-6 text-center bg-white rounded-xl border-2 shadow-lg border-primary">
                        <p class="mb-2 text-gray-600">Valor da 1ª parcela</p>
                        <p class="mb-4 text-3xl font-extrabold text-gray-800 lg:text-4xl"
                            x-text="formatCurrency(monthlyPayment)"></p>
                        <div class="text-sm text-gray-500 space-y-1">
                            <p>Renda mínima <span class="font-semibold" x-text="formatCurrency(minimumIncome)"></span></p>
                            <p>Amortização <span class="font-semibold text-blue-600" x-text="formatCurrency(monthlyAmortization)"></span></p>
                            <p>Juros <span class="font-semibold text-cyan-500" x-text="formatCurrency(monthlyInterest)"></span></p>
                            <p>Seguros & Taxas <span class="font-semibold text-red-500" x-text="formatCurrency(monthlyInsurance)"></span></p>
                        </div>
                        <div class="mt-4 text-xs text-gray-400">
                            <p>Encontramos 9 imóveis no seu perfil</p>
                        </div>
                        <button
                            class="py-3 mt-6 w-full font-semibold text-white rounded-lg shadow-md transition bg-red-600 hover:bg-red-700">VER OS IMÓVEIS</button>
                    </div>
                </div>
                
                <!-- Chart -->
                <div class="lg:col-span-1">
                    <div class="p-6 bg-white rounded-xl shadow-lg">
                        <div class="relative w-48 h-48 mx-auto">
                            <svg class="w-48 h-48 transform -rotate-90" viewBox="0 0 100 100">
                                <!-- Background circle -->
                                <circle cx="50" cy="50" r="40" fill="none" stroke="#e5e7eb" stroke-width="8"></circle>
                                
                                <!-- Amortization segment -->
                                <circle cx="50" cy="50" r="40" fill="none" stroke="#1556ac" stroke-width="8"
                                    :stroke-dasharray="amortizationCircumference + ' ' + (251.2 - amortizationCircumference)"
                                    stroke-dashoffset="0"></circle>
                                
                                <!-- Interest segment -->
                                <circle cx="50" cy="50" r="40" fill="none" stroke="#3dd5f3" stroke-width="8"
                                    :stroke-dasharray="interestCircumference + ' ' + (251.2 - interestCircumference)"
                                    :stroke-dashoffset="-amortizationCircumference"></circle>
                                
                                <!-- Insurance segment -->
                                <circle cx="50" cy="50" r="40" fill="none" stroke="#ef4444" stroke-width="8"
                                    :stroke-dasharray="insuranceCircumference + ' ' + (251.2 - insuranceCircumference)"
                                    :stroke-dashoffset="-(amortizationCircumference + interestCircumference)"></circle>
                            </svg>
                            
                            <!-- Center text -->
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <div class="text-xs text-gray-500">Valor da 1ª parcela</div>
                                <div class="text-lg font-bold" x-text="formatCurrency(monthlyPayment)"></div>
                            </div>
                        </div>
                        
                        <!-- Legend -->
                        <div class="mt-4 space-y-2 text-sm">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-blue-600 rounded mr-2"></div>
                                <span>Amortização</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-cyan-400 rounded mr-2"></div>
                                <span>Juros</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-red-500 rounded mr-2"></div>
                                <span>Seguros & Taxas</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function loanSimulator() {
        return {
            propertyValue: 700000,
            downPaymentPercent: 20,
            loanTerm: 30,
            interestRate: 0.08,
            
            get downPaymentValue() {
                return this.propertyValue * (this.downPaymentPercent / 100);
            },
            
            get loanAmount() {
                return this.propertyValue - this.downPaymentValue;
            },
            
            get monthlyPayment() {
                const principal = this.loanAmount;
                const months = this.loanTerm * 12;
                const monthlyRate = this.interestRate / 12;
                const payment = principal * monthlyRate / (1 - Math.pow(1 + monthlyRate, -months));
                return payment + this.monthlyInsurance;
            },
            
            get monthlyAmortization() {
                const principal = this.loanAmount;
                const months = this.loanTerm * 12;
                const monthlyRate = this.interestRate / 12;
                const payment = principal * monthlyRate / (1 - Math.pow(1 + monthlyRate, -months));
                const interest = principal * monthlyRate;
                return payment - interest;
            },
            
            get monthlyInterest() {
                const principal = this.loanAmount;
                const monthlyRate = this.interestRate / 12;
                return principal * monthlyRate;
            },
            
            get monthlyInsurance() {
                return 89; // Valor fixo para seguros e taxas
            },
            
            get minimumIncome() {
                return this.monthlyPayment * 3.33; // Renda mínima baseada em 30% da renda
            },
            
            // Cálculos para o gráfico circular
            get totalCircumference() {
                return 2 * Math.PI * 40; // raio = 40
            },
            
            get amortizationPercentage() {
                return (this.monthlyAmortization / this.monthlyPayment) * 100;
            },
            
            get interestPercentage() {
                return (this.monthlyInterest / this.monthlyPayment) * 100;
            },
            
            get insurancePercentage() {
                return (this.monthlyInsurance / this.monthlyPayment) * 100;
            },
            
            get amortizationCircumference() {
                return (this.amortizationPercentage / 100) * this.totalCircumference;
            },
            
            get interestCircumference() {
                return (this.interestPercentage / 100) * this.totalCircumference;
            },
            
            get insuranceCircumference() {
                return (this.insurancePercentage / 100) * this.totalCircumference;
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
