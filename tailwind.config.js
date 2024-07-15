/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
  ],
  theme: {
    extend: {
      colors: {
        'primary': {
          '100': '#B3DBD6',
          '300': '#94B8B4',
          '600': '#0C4842',
        },
        'secondary': '#3A3226',
        'tertiary': '#C73E3A',
      }
    },
  },
  plugins: [],
}