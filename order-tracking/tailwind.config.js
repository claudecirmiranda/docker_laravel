/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
        colors: {
            primary: '#0046B4',
            neutral: {
                300: '#d9d9d9',
                400: '#ADA9A9',
                500: '#797979',
            },
            success: '#00DAB3'
        },
        fontFamily: {
            baloo: ['"Baloo 2"', 'system-ui'],
        },
        keyframes: {
            slidein: {
            from: {
                opacity: "0",
                transform: "translateY(-10px)",
            },
            to: {
                opacity: "1",
                transform: "translateY(0)",
            },
            },
        },
        animation: {
            slidein: "slidein 1s ease 300ms",
        },
    },
  },
  plugins: [],
}

