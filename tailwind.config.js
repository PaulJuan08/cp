import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import preline from 'preline/plugin'; // Import Preline plugin

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class', // Enable dark mode via class
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        'node_modules/preline/dist/*.js',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                darkBackground: '#1a202c', // Dark mode background
                darkText: '#f7fafc',       // Dark mode text
            },
        },
    },
    plugins: [
        forms,
        require('preline/plugin'),
    ],
};