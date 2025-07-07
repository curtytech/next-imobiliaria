import './bootstrap';

import { createIcons } from 'lucide';
import Glide from 'glidejs';

// Initialize lucide icons on page load
if (typeof window !== 'undefined') {
    window.lucide = { createIcons };
    document.addEventListener('DOMContentLoaded', () => {
        createIcons();
    });
}

// Helper to initialize Glide carousels
window.initGlide = (selector, options = {}) => {
    if (typeof Glide !== 'undefined') {
        new Glide(selector, options).mount();
    }
};
