import "./bootstrap";

import { createIcons } from "lucide";
import Glide from "glidejs";

// Initialize lucide icons on page load
if (typeof window !== "undefined") {
	window.lucide = { createIcons };
	document.addEventListener("DOMContentLoaded", () => {
		createIcons();
	});
}

// Helper to initialize Glide carousels
window.initGlide = (selector, options = {}) => {
	if (typeof Glide !== "undefined") {
		new Glide(selector, options).mount();
	}
};

// Loan Simulator Alpine.js component
window.loanSimulator = () => ({
	propertyValue: 300000,
	downPayment: 50000,
	loanTerm: 20,
	interestRate: 0.09,
	get monthlyPayment() {
		const principal = this.propertyValue - this.downPayment;
		const months = this.loanTerm * 12;
		const monthlyRate = this.interestRate / 12;
		return (principal * monthlyRate) / (1 - Math.pow(1 + monthlyRate, -months));
	},
	formatCurrency(value) {
		return value.toLocaleString("pt-BR", {
			style: "currency",
			currency: "BRL",
		});
	},
});
