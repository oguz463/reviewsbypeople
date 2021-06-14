const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            flex: {
                '2': '2 2 0%',
                '3': '3 3 0%',
                '4': '4 4 0%',
            }
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
            borderWidth: ['hover'],
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('tailwind-scrollbar'),
    ],
};
