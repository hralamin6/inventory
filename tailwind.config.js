const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

module.exports = {
    darkMode: 'class',
    theme: {
        screen: {
            sm: "576px",
            md: "768px",
            lg: "992px",
            xl: "1200px",
        },
        container: {
            center: true,
            padding: "1rem",
        },
        extend: {
            fontFamily: {
                poppins: ["Poppins", "sans-serif"],
                roboto: ["Roboto", "sans-serif"],
                myfont: ["MyFont", "sans-serif"],
            },
            colors: {
                primary: "#fd3d57",
            },
        },
    },
    variants: {
        scrollbar: ['dark'],
        extend: {
            colors: {
                danger: colors.rose,
                primary: colors.blue,
                success: colors.green,
                warning: colors.yellow,
            },
            backgroundColor: ['active'],
        }
    },
    mode: 'jit',

    content: [
        './app/**/*.php',
        './resources/**/*.html',
        './resources/**/*.js',
        './resources/**/*.jsx',
        './resources/**/*.ts',
        './resources/**/*.tsx',
        './resources/**/*.php',
        './resources/**/*.vue',
        './resources/**/*.twig',
    ],
    plugins: [
        require('tailwind-scrollbar'),
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
};


