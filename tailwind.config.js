import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    50:  '#eeeef8',
                    100: '#d4d4ee',
                    200: '#a8a8dd',
                    300: '#7c7cc9',
                    400: '#5555b0',
                    500: '#333385',
                    600: '#2d2d76',
                    700: '#252562',
                    800: '#1e1e4f',
                    900: '#16163b',
                    950: '#0e0e27',
                },
            },
        },
    },

    plugins: [forms],
};
