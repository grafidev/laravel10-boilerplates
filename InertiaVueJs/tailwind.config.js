const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        './node_modules/flowbite/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Lato', 'system-ui', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            // colors: {
            //     'teal': {
            //         '50': '#f0fdfa',
            //         '100': '#ccfbf1',
            //         '200': '#99f6e4',
            //         '300': '#5eead4',
            //         '400': '#2dd4bf',
            //         '500': '#14b8a6',
            //         '600': '#0d9488',
            //         '700': '#0f766e',
            //         '800': '#115e59',
            //         '900': '#134e4a',
            //         '950': '#042f2e',
            //     },
            // }
        },
    },

    plugins: [
        require('@tailwindcss/forms'), 
        require('flowbite/plugin'),
    ],
};
