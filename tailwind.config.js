/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './assets/**/*.{js,ts,scss}',
        './templates/**/*.{html,twig}',
    ],
    theme: {
        extend: {},
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('@tailwindcss/aspect-ratio'),
    ],
}

