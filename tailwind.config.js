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
                sans: ['"Inter Variable"', 'Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    50:  '#fbeff1',
                    100: '#f6dde1',
                    200: '#ecc0c8',
                    300: '#d98b9a',
                    400: '#c24d63',
                    500: '#a23449',
                    600: '#8a2a3b',
                    700: '#6b1a28',
                    800: '#4f111d',
                    900: '#3a0c15',
                },
                paper: '#fcf7f8',
                ink: '#2b1a1e',
            },
        },
    },

    plugins: [forms],   
};