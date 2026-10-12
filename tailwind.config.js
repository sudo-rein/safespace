import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

   extend: {
    fontFamily: {
        sans: ['"Inter Variable"', 'Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
    },
    colors: {
        brand: {
            50:  '#FBF2F3',
            100: '#F5E0E3',
            200: '#E8BFC5',
            300: '#D6929B',
            400: '#BC5C69',
            500: '#9C3545',
            600: '#8A2837',
            700: '#7A1F2B',
            800: '#5E1721',
            900: '#43101A',
        },
        paper: '#FAF7F5',
        ink: '#2B2325',
    },
},
    plugins: [forms],
};
