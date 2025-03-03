import defaultTheme from 'tailwindcss/defaultTheme';
import flowbite from 'flowbite/plugin';

export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './node_modules/flowbite/**/*.js', // Flowbite components
    ],
    theme: {
        extend: {
            colors: {
                primary: '#7A1414', // Dark Red
                secondary: '#000000', // Black
                accent: '#D9D9D9', // Light Gray
                neutral: '#333333', // Charcoal Gray
                backgroundLight: '#FFFFFF', // Light Background
                backgroundDark: '#000000', // Dark Background
                textLight: '#333333', // Light Text
                textDark: '#D9D9D9', // Dark Text
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [
        flowbite, // Flowbite plugin
    ],
    darkMode: 'class', // Enable class-based dark mode
};
